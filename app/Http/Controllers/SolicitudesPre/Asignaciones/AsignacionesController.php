<?php

namespace App\Http\Controllers\SolicitudesPre\Asignaciones;

use App\User;
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
use App\Models\SolicitudesPre\HistorialAsignacion;
use App\Models\SolicitudesPre\AsignacionSolPre;
use App\Models\SolicitudesPre\SeguimientoSolPre;
use App\Models\Solicitud;
use App\UserOptions;
use Spatie\Permission\Models\Role;

class AsignacionesController extends Controller
{


    public function solicitudesTecnico()
    {
      try {
        $data=['title'=>'Solicitudes PRE asignadas',
          'subtitle'=>''
        ];
        return view('solicitudes.asignaciones.solicitudesTecnico',$data);
      } catch (\Exception $e) {
        Log::error('Error al intentar visualizar las asignaciones de una solicitud',['time'=>date('Y-m-d H:i:s'),'user'=>Auth::user()->idUsuario]);
        return 'Ocurrió un error, contacte a informática ahora mismo';
      }

    }
     public function getSolicitudesTecnicoPre(Request $request){
      //dd($request->idsesion);
        $solicitudes=Solicitud::getSolicitudesTecnico(Auth::User()->idUsuario);
        return Datatables::of($solicitudes)
           ->addColumn('opciones',function($dt)
            {
              $opc = '';
              switch ($dt->idEstado) {
                case 2:
                      if($dt->solicitudPortal==0){
                    $opc .= '<a title="Dictaminar" href="'.route('versolicitudDic',['idSolicitud'=>$dt->idSolicitud, 'consultar'=>1,'solicitudPortal'=>$dt->solicitudPortal]).'" class="btn btn-success btn-sm"><i class="fa fa-legal"></i></a> <a href="'.route('editarsolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2,'tipoSolicitud'=>$dt->tipoSolicitud]).'" class="btn btn-info btn-sm"><b><i class="fa fa-edit"></i></b></a>';
                  } else {
                     $opc .= '<a title="Dictaminar" href="'.route('versolicitudDic',['idSolicitud'=>$dt->idSolicitud, 'consultar'=>1,'solicitudPortal'=>$dt->solicitudPortal]).'" class="btn btn-success btn-sm"><i class="fa fa-legal"></i></a>';
                  }
                  break;
                case 3:
                    $opc .= '  <a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                  break;
                case 4:
                    if($dt->solicitudPortal==0){
                        $opc .= '<a title="Dictaminar" href="'.route('versolicitudDic',['idSolicitud'=>$dt->idSolicitud, 'consultar'=>1,'solicitudPortal'=>$dt->solicitudPortal]).'" class="btn btn-success btn-sm"><i class="fa fa-legal"></i></a> <a href="'.route('editarsolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2,'tipoSolicitud'=>$dt->tipoSolicitud]).'" class="btn btn-info btn-sm"><b><i class="fa fa-edit"></i></b></a> <a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                    } else {
                        $opc .= '<a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                    }
                    break;
                case 5:
                    $opc .= '  <a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                    break;
                  case 9:
                        $opc .= '  <a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                  break;
                  case 11:
                     $opc .= '<a title="Dictaminar" href="'.route('versolicitudDic',['idSolicitud'=>$dt->idSolicitud, 'consultar'=>1,'solicitudPortal'=>$dt->solicitudPortal]).'" class="btn btn-success btn-sm"><i class="fa fa-legal"></i></a>';
                  break;
                  default:
                  $opc .= '  <a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>0]).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                  break;
              }

              return $opc;
            })
            ->addColumn('diasTranscurridos',function($dt){
                      $fecha= Carbon::parse($dt->fechaEnvio);
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
            ->blacklist(['fecha'])
            ->rawColumns(['opciones','diasTranscurridos','plazo'])
          ->make(true);

      }



    public function index()
    {
      try {
        $data=['title'=>'Asignación de Solicitudes PRE',
          'subtitle'=>'',
          'usuarios'=>User::whereHas('roles',function ($q){
                        $q->where('name','tecnico_coshig');
          })->get()
        ];

        return view('solicitudes.asignaciones.show',$data);
      } catch (\Exception $e) {
          dd($e);
        Log::error('Error al intentar visualizar las asignaciones de una solicitud',['time'=>date('Y-m-d H:i:s'),'user'=>Auth::user()->idUsuario]);
        return 'Ocurrió un error, contacte a informática ahora mismo';
      }

    }


      public function getSolicitudesAsignarPre(Request $request){
      //dd($request->idsesion);
        $solicitudes=Solicitud::getSolicitudesAsignar();
        return Datatables::of($solicitudes)
            ->addColumn('opciones',function($dt)
            {
              return '<a href="'.route('index.asignar.pre.sol',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-info btn-sm"><b><i class="fa fa-edit"></i></b></a>';
            })
            ->addColumn('diasTranscurridos',function($dt){
                      $fecha= Carbon::parse($dt->fechaEnvio);
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
                  $asig= AsignacionSolPre::where('idSolicitud',$dt->idSolicitud)->get();
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
        $asignados = AsignacionSolPre::where('idSolicitud',$idSol)->pluck('usuarioAsignado')->toarray();
        $data=['title'=>'Asignación de Solicitudes PRE - Número de solicitud '.$sol->numeroSolicitud,
          'subtitle'=>'',
            'usuarios'=>User::whereHas('roles',function ($q){
                                        $q->where('name','tecnico_coshig');
                          })->get(),
          'asignados'=>$asignados,
          'idSolicitud' => $idSol
        ];
        return view('solicitudes.asignaciones.asignarTecnicos',$data);

      } catch (\Exception $e) {
        Log::error('Error al intentar visualizar las asignaciones de una solicitud',['time'=>date('Y-m-d H:i:s'),'user'=>Auth::user()->idUsuario]);
        Log::error($e);
        return 'Ocurrió un error, contacte a informática ahora mismo';
      }

    }

    public function store(Request $request)
    {
      try {

        $rules = [
            'idSolicitud'      => 'required',
            'usuario'          => 'required|array|min:1',
        ];
        $messages =  [
            'idSolicitud.required'      => 'Debe de ingresar el id Solicitud',
            'usuario.required'          => 'Debe de selecionar uno o más usuarios',
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
                        $asi = new AsignacionSolPre();
                        $asi->idSolicitud = $request->idSolicitud;
                        $asi->usuarioAsignado = $usuario;
                        $asi->usuarioCreacion = $usuarioCreacion;
                        $asi->save();

                        $hist = new SeguimientoSolPre();
                        $hist->idSolicitud = $request->idSolicitud;
                        $hist->idEstado=2;
                        $hist->seguimiento='Se agrego al siguiente técnico a la solicitud: '.$usuario;
                        $hist->usuarioCreacion =$usuarioCreacion;
                        $hist->save();
            }
            $soli->estado=2;
            $soli->save();

           return response()->json(['status'=>200,'message' => '¡Se enviaron los datos con éxito!']);

      } catch (\Exception $e) {
        return $e;
         Log::error('LOError Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
         return response()->json(['status' => 404, 'message' => '¡Problemas al guardar los datos!'],200);
      }

    }
}
