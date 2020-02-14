<?php

namespace App\Http\Controllers\SolicitudesPost;

use Illuminate\Http\Request;
use  App\Http\Requests\SolicitudesPre\Asignaciones\RequestAsignacion;
use App\Http\Controllers\Controller;

use Auth;
use Crypt;
use Validator;
use Response;
use Log;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Models\SolicitudesPost\Solicitud;
use App\Models\SolicitudesPost\SolicitudSeguimiento;
use App\Models\SolicitudesPost\AsignacionSolPost;
use App\Models\SolicitudesPost\vwSolicitudes;
use App\User;

class AsignacionesController extends Controller
{

    public function solicitudesTecnico(){
        $data = ['title' => 'Solicitudes POST asignadas',
                 'subtitle' => ''];

        return view('postRegistro.solicitudesTecnico', $data);
    }

      public function getSolicitudesTecnicoPost(Request $request){
      //dd($request->idsesion);
        $solicitudes = vwSolicitudes::getSolicitudTecnico(Auth::User()->idUsuario);
        return Datatables::of($solicitudes)
            ->addColumn('opciones',function($dt){
                    if($dt->idEstado==2){
                        return '<a  href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-xs btn-info" title="Revisar">REVISAR</a>';
                    }
                    else{
                        return '<a  href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-xs btn-success" title="Ver"><i class="fa fa-search"></i></a>';
                    }

            })
            ->addColumn('diasTranscurridos',function($dt){
                      $fecha= Carbon::parse($dt->fechaInicio);
                      $now = Carbon::now('America/El_Salvador');
                      //return $now->diffInDays($fechaRecepcion); //dias transcurridos incluyendo fines de semana
                      $diasHabiles = $this->getDiasHabiles($fecha,$now);
                      return $diasHabiles;
            })
            ->addColumn('plazo',function($dt){
                if ($dt->plazo) {//los dias en la solicitud
                 return '<span class="label '.$this->getPlazo($dt->plazoEstado,$dt->plazo).'">'.$dt->plazo.'</span>';
                }
                return '---';
            })->rawColumns(['opciones','diasTranscurridos','plazo'])
            ->make(true);

      }



    public function index()
    {
      try {

        $data=['title'=>'Asignación de Solicitudes POST',
          'subtitle'=>'',
          'usuarios'=>User::whereHas('roles',function ($q){
              $q->where('name','tecnico_coshig');
          })->get()
        ];
        return view('postRegistro.solicitudesAsignar',$data);

      } catch (\Exception $e) {
        Log::error('Error al intentar visualizar las asignaciones de una solicitud',['time'=>date('Y-m-d H:i:s'),'user'=>Auth::user()->idUsuario]);
        return 'Ocurrió un error, contacte a informática ahora mismo';
      }

    }


      public function getSolicitudesAsignarPost(Request $request){
      //dd($request->idsesion);
        $solicitudes=vwSolicitudes::getSolicitudAsignar();
        return Datatables::of($solicitudes)
          ->addColumn('opciones',function($dt)
            {
              return '<a href="'.route('index.asignar.post.sol',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-info btn-sm"><b><i class="fa fa-edit"></i></b></a>';
            })
            ->addColumn('diasTranscurridos',function($dt){
                      $fecha= Carbon::parse($dt->fechaInicio);
                      $now = Carbon::now('America/El_Salvador');
                      //return $now->diffInDays($fechaRecepcion); //dias transcurridos incluyendo fines de semana
                      $diasHabiles = $this->getDiasHabiles($fecha,$now);
                      return $diasHabiles;
            })
            ->addColumn('plazo',function($dt){
                if ($dt->plazo) {//los dias en la solicitud
                 return '<span class="label '.$this->getPlazo($dt->plazoEstado,$dt->plazo).'">'.$dt->plazo.'</span>';
                }
                return '---';
            })
            ->addColumn('usuarioAsignado',function($dt){
                  $asig= AsignacionSolPost::where('idSolicitud',$dt->idSolicitud)->get();
                  if(count($asig)>0){
                        $tec="";
                        foreach($asig as $d){
                          $tec .= " $d->usuarioAsignado <br> ";
                        }
                        $msgSolicitudes="<span class='label label-primary'>$tec</span>";
                        return $msgSolicitudes;
                  }else{
                       return '';
                  }

            })->rawColumns(['opciones','diasTranscurridos','plazo','usuarioAsignado'])
          ->make(true);

      }


    public function indexAsignaciones($idSolicitud)
    {
      try {

        $idSol = Crypt::decrypt($idSolicitud);
        $sol = Solicitud::find($idSol);
        $asignados = AsignacionSolPost::where('idSolicitud',$idSol)->pluck('usuarioAsignado')->toarray();
        $data=['title'=>'Asignación de Solicitudes POST - Número de solicitud '.$sol->numeroSolicitud,
          'subtitle'=>'',
            'usuarios'=>User::whereHas('roles',function ($q){
                $q->where('name','tecnico_coshig');
            })->get(),
          'asignados'=>$asignados,
          'idSolicitud' => $idSol
        ];
        return view('postRegistro.asignarTecnico',$data);

      } catch (\Exception $e) {
        Log::error('Error al intentar visualizar las asignaciones de una solicitud',['time'=>date('Y-m-d H:i:s'),'user'=>Auth::user()->idUsuario]);
        return 'Ocurrió un error, contacte a informática ahora mismo';
      }

    }

    public function store(Request $request)
    {

      try {
        $rules = [
            'usuario'              => 'required|array|min:1',
            'idSolicitud'          => 'required',
        ];
        $messages =  [
            'usuario.required'      => 'Debe de selecionar una o más usuarios',
            'idSolicitud.required'          => 'Debe de ingresar el id de la solicitud',
        ];

        $v = Validator::make($request->all(),$rules,$messages);

         if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 404, 'message' => $msg],200);
        }
           $usuarioCreacion= Auth::User()->idUsuario . '@' . $request->ip();

           $soli = Solicitud::findOrFail($request->idSolicitud);
           $soli->asignacion()->delete();
           foreach($request->usuario as $key => $usuario){
                        $asi = new AsignacionSolPost();
                        $asi->idSolicitud = $request->idSolicitud;
                        $asi->usuarioAsignado = $usuario;
                        $asi->usuarioCreacion = $usuarioCreacion;
                        $asi->save();

                        $hist = new SolicitudSeguimiento();
                        $hist->idSolicitud = $request->idSolicitud;
                        $hist->idEstado=2;
                        $hist->seguimiento='Se agrego al siguiente técnico a la solicitud: '.$usuario;
                        $hist->usuarioCreacion =$usuarioCreacion;
                        $hist->save();
            }
            $soli->idEstado=2;
            $soli->save();


           return response()->json(['status'=>200,'message' => '¡Se enviaron los datos con éxito!']);

      } catch (\Exception $e) {
        return $e;
         Log::error('LOError Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
         return response()->json(['status' => 404, 'message' => '¡Problemas al guardar los datos!'],200);
      }

    }
}
