<?php

namespace App\Http\Controllers\Sesion;

use App\Models\SolicitudesPost\Solicitud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sesion;
use App\Models\SesSolictudesAprobadas;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\Datatables\Datatables;

use DB;
use Auth;
use Session;
use Validator;
use Response;
use Log;
use Carbon\Carbon;
use App\UserOptions;
use App\Models\Profesional;
use App\Models\Cosmetico;
use App\Models\Higienico;
use App\Models\SolicitudesSesion;
use App\Models\VwPropietario;
use App\Models\Cosmeticos\FabricantesCosmeticos;
use App\Models\Distribuidores;
use App\Models\Propietario;
use App\Models\SolicitudesPost\Solicitud as SolicitudPost;
use App\Models\SolicitudesPost\SolicitudSeguimiento;
use App\Models\SolicitudesPost\SolPostEstadosSesion;
use App\Http\Controllers\SolicitudesPost\CertificacionController;
use App\Models\SolicitudesPost\vwSolicitudes;

class SesionPostController extends Controller
{
    //
    public function indexSesion(Request $request)
    {

        $data = ['title' => 'ADMINISTRADOR DE SESIONES',
            'subtitle' => ''];
        $ruta = "getsesiones.sesionespost"; //index de sesiones para agregar solicitudes por técnico
        $data['ruta'] = $ruta;
        $data['idTipo']=2;
        return view('sesiones.indexSesiones', $data);
    }
    public function getSesiones(){
        $sesiones=Sesion::getSesiones();
        return Datatables::of($sesiones)
            ->addColumn('nombreSesion',function($dt){
                if($dt->estadoSesion=='EN CURSO'){
                    return '<a href="'.route('agregarsolicitudes.sesionespost',['idSesion'=>Crypt::encrypt($dt->idSesion)]).'" class="btn btn-primary btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
                } else {
                    return '<a href="'.route('agregarsolicitudes.sesionespost',['idSesion'=>Crypt::encrypt($dt->idSesion)]).'" class="btn btn-warning btn-sm"><b>'.$dt->nombreSesion.'</b></a>';

                }
            })->rawColumns(['nombreSesion'])
            ->make(true);

    }
    public function indexSesionAprobar(Request $request)
    {

        $data = ['title' => 'ADMINISTRADOR DE SESIONES (APROBAR)',
            'subtitle' => ''];
        $ruta = "getsesiones.sesionespost.jefes"; //index de sesiones para aprobar solicitudes por jefe
        $data['ruta'] = $ruta;
        return view('sesiones.indexSesionesJefes', $data);
    }

     public function getSesionesJefes(){
        $sesiones=Sesion::getSesiones();
        return Datatables::of($sesiones)
            ->addColumn('nombreSesion',function($dt){
                if($dt->estadoSesion=='EN CURSO'){
                    return '<a href="'.route('aprobarsolicitudes.sesionespost',['idSesion'=>Crypt::encrypt($dt->idSesion)]).'" class="btn btn-primary btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
                } else {
                    return '<a href="'.route('aprobarsolicitudes.sesionespost',['idSesion'=>Crypt::encrypt($dt->idSesion)]).'" class="btn btn-warning btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
                }
            })->rawColumns(['nombreSesion'])
            ->make(true);

    }

    public function agregarSolicitudes($idSesion)
    {
        $sesion=Sesion::findOrFail(Crypt::decrypt($idSesion));

        $data = ['title' => 'ADMINISTRADOR DE SOLICITUDES FAVORABLES PARA LA SESIÓN '.$sesion->nombreSesion,
            'subtitle' => ''];
        $data['sesion']=$sesion;

        return view('sesiones.post.solicitudesPostFav', $data);
    }
     public function dtRowsSolPostFav(Request $request){
        //dd($request->idsesion);
        $solicitudes=vwSolicitudes::favParaSesion($request->idsesion);
        return Datatables::of($solicitudes)
            ->addColumn('numSolicitud',function($dt){
                return '<a href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" target="_blank" class="btn btn-primary btn-sm"><b>'.$dt->numeroSolicitud.'</b></a>';
            })

            ->addColumn('agregar',function($dt){
                if($dt->idEstado==3 || $dt->idEstado==5){
                    return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';
                }
                elseif($dt->idEstado==7){
                    return '';
                }
                elseif($dt->idEstado==6) {
                    return '<a class="btn btn-danger btn-sm" onclick="desaprobar('.$dt->idSolicitud.')" >DESAPROBAR</button>';
                }
            })->rawColumns(['numSolicitud','agregar'])
            ->make(true);
    }

    public function aprobarSolicitudes($idSesion)
    {
        $sesion=Sesion::findOrFail(Crypt::decrypt($idSesion));

        $data = ['title' => 'ADMINISTRADOR DE SOLICITUDES PARA APROBAR EN LA SESIÓN '.$sesion->nombreSesion,
            'subtitle' => ''];
        $data['sesion']=$sesion;
        $data['permisos']=UserOptions::getAutUserOptions();

        return view('sesiones.post.solicitudesPostAprobar', $data);
    }

    public function dtRowsSolPostAgregadas(Request $request){
        //dd($request->idsesion);
        $solicitudes=Sesion::getSolicitudesParaAprobarPost($request->idsesion);
        return Datatables::of($solicitudes)
            ->addColumn('numSolicitud',function($dt){
                return '<a href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" target="_blank" class="btn btn-primary btn-sm"><b>'.$dt->numeroSolicitud.'</b></a>';
            })
            ->addColumn('agregar',function($dt){
                if($dt->estadoSolSesion==0 && $dt->idEstado==6 && $dt->estadoSesion==1){
                  return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';
                } else {
                    return '';
                }
            })->rawColumns(['numSolicitud','agregar'])
            ->make(true);
    }

    public function addSolPostSesion(Request $request){  //método que agrega las solicitudes a sesión con aprobacion del técnico
        //dd($request->all());

        DB::connection('sqlsrv')->beginTransaction();
        try{
            $sesion=Sesion::findOrFail($request->idSesion);


            for($i=0;$i<count($request->sol);$i++){
                $solSesiones= new SolicitudesSesion();
                $solSesiones->idSesion=$sesion->idSesion;
                $solSesiones->idSolicitud=$request->sol[$i];
                $solSesiones->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
                $solSesiones->estadoSolSesion=0;
                $solSesiones->tipoSolicitud=2;
                $solSesiones->save();

                $sol= SolicitudPost::find($request->sol[$i]);
                $sol->idEstado=6;
                $sol->usuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
                $sol->save();

                SolicitudSeguimiento::create(['idSolicitud'=>$request->sol[$i],'idEstado'=>6,'seguimiento'=>'Solicitud se agrego para aprobación a sesión.','usuarioCreacion'=>Auth::user()->idUsuario.'@'.$request->ip()]);

            }

            Session::flash('message','Se ingresaron solicitudes con éxito a la sesión '.$sesion->nombreSesion);
        }  catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return back();
        }
        $data=['title'=>'ADMINISTRADOR DE SOLICITUDES FAVORABLES PARA LA SESIÓN '.$sesion->nombreSesion,
            'subtitle'=>''
        ];
        $data['sesion']=$sesion;

        DB::connection('sqlsrv')->commit();
        return view('sesiones.post.solicitudesPostFav',$data);
    }

    public function aprobarSolPostSesion(Request $request){  //método que agrega las solicitudes a sesión con aprobacion del técnico
        DB::connection('sqlsrv')->beginTransaction();
        try{
                $rules = [
                    'idSesion'      => 'required',
                    'sol'           => 'required|array',
                ];
                $messages =  [
                    'idSesion.required'   => 'id sesion es requerido',
                    'sol.required'        => 'Seleccionar una o más solicitudes',
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

            $sesion=Sesion::findOrFail($request->idSesion);
            $usuarioMod= Auth::User()->idUsuario.'@'.$request->ip();
            $solicitudes=$request->sol;
            $msgSolicitudes= "<ul><li>Se ingresaron solicitudes con éxito</li>";
            $solicitudesNo=[];

            foreach($solicitudes as $key => $sol){
                $fabricante='';
                $titular='';
                $soli=SolicitudPost::where('idSolicitud',$sol)->first();
                //-----------------FABRICANTE------------------
                if($soli->tipoProducto=='COS'){
                        $producto=Cosmetico::find($soli->noRegistro);
                        $fabri1= Cosmetico::existeFabri($soli->noRegistro);
                        if ((count($fabri1)) > 0) {
                            $d1 = Cosmetico::getFabricantes($soli->noRegistro);
                            if(count($d1)==1){
                                    foreach($d1  as $jj){
                                            $fabricante .= $jj->NOMBRE_COMERCIAL."(".$jj->pais.")";
                                    }
                            }else{
                                foreach($d1  as $kk){
                                  $fabricante .= $kk->NOMBRE_COMERCIAL."(".$kk->pais."), ";
                                }
                            }
                        } else {
                            $fabricante = '';
                            array_push($solicitudesNo, $sol);
                            $msgSolicitudes.="<li>El producto $soli->noRegistro no posee ningún fabricante</li>";
                        }
                }else{
                        $producto = Higienico::find($soli->noRegistro);
                        $fabri2=Higienico::existeFabri($soli->noRegistro);
                        if ((count($fabri2))>0){
                          $d2=Higienico::getFabricantes($soli->noRegistro);
                          if(count($d2)>1){
                                    foreach($d2  as $pp){
                                            $fabricante .= $pp->NOMBRE_COMERCIAL."(".$pp->pais.")";
                                    }
                            }else{
                                foreach($d2  as $rr){
                                  $fabricante .= $rr->NOMBRE_COMERCIAL."(".$rr->pais."), ";
                                }
                            }
                        }else{
                             $fabricante = '';
                            array_push($solicitudesNo, $sol);
                            $msgSolicitudes.="<li>El producto $soli->noRegistro no posee ningún fabricante</li>";
                        }

                }
                //dd($fabricante);
                //---------------------TITULAR----------------------------
                if(!empty($producto->tipoTitular) && !empty($producto->idTitular)) {
                    if ($producto->tipoTitular != 3) {
                        if (VwPropietario::find($producto->idTitular) != null) {
                            $propietario = Propietario::getTitular($producto->idTitular, $producto->tipoTitular);
                            $titular = $propietario->nombre;
                        }
                    } else {
                        if (Propietario::find($producto->idTitular) != null) {
                            $propietario = Propietario::getTitular($producto->idTitular, $producto->tipoTitular,1);
                            $titular = $propietario->nombre;
                        }
                    }
                }else{
                    $titular='';
                    array_push($solicitudesNo, $sol);
                    $msgSolicitudes.="<li>El producto $soli->noRegistro no posee ningún titular</li>";
                }
                if(!in_array($sol, $solicitudesNo,true)){
                    SesSolictudesAprobadas::create(['idRegistro'=>$soli->noRegistro,'nombreRegistro'=>$producto->nombreComercial,'nombreTitular'=>$titular,'nombreFabricante'=>$fabricante,'idSolicitud'=>$sol,'idUnidad'=>7,'tipoSolicitud'=>$soli->idTramite,'nombreTramite'=>$soli->tramite->nombreTramite,'idSesion'=>$sesion->nombreSesion,'fechaSolicitud'=>$soli->fechaCreacion,'fechaSesion'=>$sesion->fechaSesion,'usuarioAprobacion'=>$usuarioMod,'fechaAprobacion'=>date('Y-m-d'),'idSistema'=>$soli->tipoProducto]);
                    SolicitudesSesion::where('idSesion',$sesion->idSesion)->where('idSolicitud',$sol)->where('tipoSolicitud',2)->update(['estadoSolSesion'=>1,'idUsuarioModifica'=>$usuarioMod]);
                    $soli->idEstado=7;
                    $soli->usuarioModificacion=$usuarioMod;
                    $soli->save();

                    SolicitudSeguimiento::create(['idSolicitud'=>$sol,'idEstado'=>7,'seguimiento'=>'Solicitud agregada a sesión '.$sesion->idSesion.'.','usuarioCreacion'=>$usuarioMod]);
                }


            }
            DB::connection('sqlsrv')->commit();
        }
        catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            return response()->json(['status' => 404, 'message' => 'Error en el sistema!'],200);
        }
        return response()->json(['status' => 200, 'message' => $msgSolicitudes],200);

    }

    public function desaprobarSol(Request $request){
        DB::connection('sqlsrv')->beginTransaction();
        try{
            $usuarioMod= Auth::User()->idUsuario.'@'.$request->ip();
            SolicitudesSesion::where('idSesion',$request->idSesion)->where('tipoSolicitud',2)->where('idSolicitud',$request->idSolicitud)->delete();
            SolicitudPost::where('idSolicitud',$request->idSolicitud)->update(['idEstado'=>3,'usuarioModificacion'=>$usuarioMod]);
            SolicitudSeguimiento::create(['idSolicitud'=>$request->idSolicitud,'idEstado'=>3,'seguimiento'=>'Solicitud fue eliminada para aprobacion a sesión','usuarioCreacion'=>$usuarioCreacion]);
            DB::connection('sqlsrv')->commit();
            return JsonResponse::create(['mensaje'=>'Solicitud desaprobada de sesión'],200);

          /* $estsol= SolPostEstadosSesion::latestEstadoSolicitud($request->idSolicitud);
            if(count($estsol)>0){
                    SolicitudesSesion::where('idSesion',$request->idSesion)->where('tipoSolicitud',2)->where('idSolicitud',$request->idSolicitud)->delete();
                    SolicitudPost::where('idSolicitud',$request->idSolicitud)->update(['idEstado'=>$estsol[0]->idEstado,'usuarioModificacion'=>$usuarioMod]);
                    SolicitudSeguimiento::create(['idSolicitud'=>$request->idSolicitud,'idEstado'=>3,'seguimiento'=>'Solicitud fue eliminada para aprobacion a sesión','usuarioCreacion'=>$usuarioMod]);

                    DB::connection('sqlsrv')->commit();
                    return JsonResponse::create(['mensaje'=>'Solicitud desaprobada de sesión'],200);
            }else{
                Log::warning('Error Exception, La solicitud post'.$request->idSolicitud.' no tiene estado para desaprobar de la sesion');
            }*/
        }
        catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            return JsonResponse::create(['mensaje'=>'No se ha podido desaprobar la Solicitud, consulte a informática'],500);        }
    }

    public function certificacionSolPost()
    {

        $data = ['title' => 'ADMINISTRADOR DE SESIONES',
            'subtitle' => ''];
        $ruta = "certificacion.sesionespost"; //index de sesiones para agregar solicitudes por técnico
        $data['ruta'] = $ruta;
         $data['idTipo']=2;
        return view('sesiones.indexSesiones', $data);
    }

    public function getSesionesCertificacion(){
        $sesiones=Sesion::getSesiones();
        return Datatables::of($sesiones)
            ->addColumn('nombreSesion',function($dt){
                return '<a href="'.route('sols.certificar.sesionespost',['idSesion'=>Crypt::encrypt($dt->idSesion)]).'" class="btn btn-primary btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
            })->rawColumns(['nombreSesion'])
            ->make(true);

    }

    public function certificarSolicitudes($idSesion)
    {
        $sesion=Sesion::findOrFail(Crypt::decrypt($idSesion));

        $data = ['title' => 'ADMINISTRADOR DE SOLICITUDES PARA CERTIFICAR '.$sesion->nombreSesion,
            'subtitle' => ''];
        $data['sesion']=$sesion;

        return view('sesiones.post.certificacionsolpost', $data);
    }

    public function dtRowsCertificacionSolPost(Request $request){
        //dd($request->idsesion);
        $solicitudes=vwSolicitudes::aCertificar($request->idsesion);
        return Datatables::of($solicitudes)
            ->addColumn('numSolicitud',function($dt) use ($request){
                return '<a href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud),'idSesion'=>Crypt::encrypt($request->idsesion)]).'" target="_blank" class="btn btn-primary btn-sm"><b>'.$dt->numeroSolicitud.'</b></a>';
            })

            ->addColumn('agregar',function($dt){
                $r3='<a  href="'.route('certificacion.requisito.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" target="_blank" class="btn btn-xs btn-info" title="CVL"><i class="fa fa-print"></i></a>';
                 //FAVORABLE
                             if($dt->idEstado==9){
                                  //CERTIFICADAS
                                 $solicitud = SolicitudPost::find($dt->idSolicitud);
                                 if(!empty($solicitud->documentocertificacionFav)){
                                     return '<button type="button" onclick="printCert(\''.Crypt::encrypt($dt->idSolicitud).'\');" class="btn btn-success btn-sm"><b>Imprimir</b></button><br><button type="button" onclick="actualizarDocumento('.$dt->idSolicitud.',3);" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Volver a generar documento"><b><i class="fa fa-refresh"></i></b></button>';
                                 }else{
                                    return '<button type="button" onclick="printCert(\''.Crypt::encrypt($dt->idSolicitud).'\');" class="btn btn-success btn-sm"><b>Imprimir</b></button>';
                                 }
                            }else if($dt->idEstado==7){
                                //EN SESIÓN
                                return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';

                            }

                /*$estsol= SolPostEstadosSesion::latestEstadoSolicitud($dt->idSolicitud);

                if(count($estsol)>0){
                    $solicitud = SolicitudPost::find($dt->idSolicitud);
                    if($estsol[0]->idEstado=='5'){
                        //DESFAVORABLE
                        if($dt->idEstado==7){
                           //EN SESION
                          return '<a target="_blank" href="'.route('pdf.dictamen.post.desfavorable',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'"  class="btn btn-danger btn-sm">DENEGAR</a>';
                        }else{
                             //DENEGADO
                            if(!empty($solicitud->documentocertificacionDesfav)){
                                return '<a target="_blank" href="'.route('pdf.dictamen.post.desfavorable',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'"  class="btn btn-success btn-sm">Imprimir</a><br><button type="button" onclick="actualizarDocumento('.$dt->idSolicitud.',5);" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Volver a generar documento"><b><i class="fa fa-refresh"></i></b></button>';
                            }else{
                                 return '<a target="_blank" href="'.route('pdf.dictamen.post.desfavorable',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'"  class="btn btn-success btn-sm">Imprimir</a>';
                            }
                        }
                    }else{
                            //FAVORABLE
                             if($dt->idEstado==9){
                                  //CERTIFICADAS
                                 if(!empty($solicitud->documentocertificacionFav)){
                                     return '<button type="button" onclick="printCert(\''.Crypt::encrypt($dt->idSolicitud).'\');" class="btn btn-success btn-sm"><b>Imprimir</b></button><br><button type="button" onclick="actualizarDocumento('.$dt->idSolicitud.',3);" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Volver a generar documento"><b><i class="fa fa-refresh"></i></b></button>';
                                 }else{
                                    return '<button type="button" onclick="printCert(\''.Crypt::encrypt($dt->idSolicitud).'\');" class="btn btn-success btn-sm"><b>Imprimir</b></button>';
                                 }
                            }else if($dt->idEstado==7){
                                //EN SESIÓN
                                return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';

                            }
                    }
                }else{
                    return '<span class="label label-warning">SOLICITUD SIN ESTADO</span>';
                }*/

            })->rawColumns(['numSolicitud','agregar'])
            ->make(true);
    }

    public function storeCertificarPost(Request $request){

        $rules = [
            'idSesion'      => 'required',
            'sol'           => 'required|array',
        ];

        $messages =  [
            'idSesion.required'      => 'id sesion es requerido',
            'sol.required'        => 'Seleccionar una o más solicitudes',
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
        DB::connection('sqlsrv')->beginTransaction();
        $msgSolicitudes= "<ul><li>Solicitudes certificadas con exito.</li>";
        $solicitudesNo=[];
        try {
            $soli = $request->sol;
            foreach($soli as $key=> $idsolicitud){
                $fabricante='';
                $solicitud = SolicitudPost::findOrFail($idsolicitud);
                if($solicitud->tipoProducto=='COS'){
                        $producto=Cosmetico::findOrFail($solicitud->noRegistro);
                }else if($solicitud->tipoProducto=='HIG'){
                        $producto=Higienico::findOrFail($solicitud->noRegistro);
                }
                //-------------------TITULAR-------------------------------------
                if($producto->tipoTitular==1 || $producto->tipoTitular==2) $titular=$producto->titular12;
                else $titular=$producto->titular3;
                if(empty($titular) || $titular== null){
                       //DB::connection('sqlsrv')->rollback();
                        array_push($solicitudesNo, $idsolicitud);
                        $msgSolicitudes.="<li>El producto $solicitud->noRegistro no posee titular</li>";
                        //return response()->json(['status' => 404, 'message' => 'Error en el sistema: El producto '.$solicitud->noRegistro.' no posee titular!'],200);
                }else{
                     if($producto->tipoTitular==3) $nombreTitular = $titular->NOMBRE_PROPIETARIO;
                        else $nombreTitular = $titular->nombre;
                }
                //--------------------PROFESIONAL------------------
                if(!empty($producto->profesional)) $profesional=$producto->profesional->profesional;
                if(empty($profesional) || is_null($profesional)){
                        array_push($solicitudesNo, $idsolicitud);
                        $msgSolicitudes.="<li>El producto $solicitud->noRegistro no posee profesional</li>";
                     //DB::connection('sqlsrv')->rollback();
                     //return response()->json(['status' => 404, 'message' => 'Error en el sistema: El producto '.$solicitud->noRegistro.' no posee profesional!'],200);

                }else{
                    $profesional=Profesional::getTratamientoProfesional($profesional->ID_PROFESIONAL);
                }
                //-------------------FABRICANTE------------------------
                $fabri = $producto::existeFabri($solicitud->noRegistro);
                if (count($fabri) > 0) {
                    $fabricantes = $producto::getFabricantes($solicitud->noRegistro);
                    //$fabricantes = FabricantesCosmeticos::fabricantes($fabri->pluck('idFabricante'));
                    if(empty($fabricantes)){
                       //DB::connection('sqlsrv')->rollback();
                       //return response()->json(['status' => 404, 'message' => 'Error en el sistema: El producto '.$solicitud->noRegistro.' no posee fabricante!'],200);
                        array_push($solicitudesNo, $idsolicitud);
                        $msgSolicitudes.="<li>El producto $solicitud->noRegistro no posee fabricante</li>";
                    }else{
                            if(count($fabricantes)>1){
                                foreach($fabricantes  as $key => $pp){
                                    if($key==0)
                                        $fabricante.= $pp->NOMBRE_COMERCIAL;
                                    else if($key==(count($fabricantes)-1))
                                        $fabricante.=', '.$pp->NOMBRE_COMERCIAL;
                                    else
                                        $fabricante.=', '.$pp->NOMBRE_COMERCIAL;
                                }
                            }else{
                                foreach($fabricantes  as $rr){
                                    $fabricante .= $rr->NOMBRE_COMERCIAL;
                                }
                            }
                    }
                } else {
                    array_push($solicitudesNo, $idsolicitud);
                    $msgSolicitudes.="<li>El producto $solicitud->noRegistro no posee fabricante</li>";

                    //DB::connection('sqlsrv')->rollback();
                    //return response()->json(['status' => 404, 'message' => 'Error en el sistema: El producto '.$solicitud->noRegistro.' no posee fabricante!'],200);
                }
                $distribuidores=$this->getDistribuidoresByProd($producto);
                if($distribuidores==null){
                    array_push($solicitudesNo, $idsolicitud);
                    $msgSolicitudes.="<li>El producto $solicitud->noRegistro no posee distribuidores</li>";
                }
                //------------------TRAMITES-----------------------------
            if(!in_array($idsolicitud, $solicitudesNo,true)){
                     //Renovación
                     if($solicitud->idTramite==1 || $solicitud->idTramite==21 || $solicitud->idTramite==22){

                        if(!in_array($idsolicitud, $solicitudesNo,true)){
                            $newrenovacion=date('Y-m-d',strtotime('+5 years',strtotime($producto->renovacion)));
                            $producto->renovacion= $newrenovacion;
                            $producto->idUsuarioModificacion=$usuarioCreacion;
                            $producto->save();

                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolRenovacion ?,?,?,?,?,?',[$solicitud->idSolicitud,
                                  $profesional->NOMBRES.' '.$profesional->APELLIDOS,$nombreTitular,
                                  $fabricantes,$usuarioCreacion,$this->convertDateToText($newrenovacion)]);
                          SolicitudSeguimiento::create(['idSolicitud'=>$solicitud->idSolicitud,'idEstado'=>9,'seguimiento'=>'Solicitud certificada','usuarioCreacion'=>$usuarioCreacion]);
                        }
                    }else if($solicitud->idTramite==6){
                            //---CAMBIO DE EMPAQUE
                            if(CertificacionController::certificarSolDocumentos($solicitud,$usuarioCreacion,6)==false){
                                DB::connection('sqlsrv')->rollback();
                                array_push($solicitudesNo, $idsolicitud);
                                $msgSolicitudes.="<li>El producto $solicitud->noRegistro no ha podido ser certificada, favor contacte con Informática</li>";
                                //return response()->json(['status' => 404, 'message' => 'Error en el sistema: La solicitud '.$solicitud->numeroSolicitud.' no ha podido ser certificada, favor contacte con Informática!'],200);
                            }
                            //dd($this->convertDateToText(date('Y-m-d')));
                            if(!in_array($idsolicitud, $solicitudesNo,true)){
                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolCVL ?,?,?,?,?,?,?',[$solicitud->idSolicitud,$profesional->tratamiento.' '.$profesional->NOMBREPROF,$nombreTitular,$fabricante,$distribuidores,$usuarioCreacion,$this->convertFechaHora(date('Y-m-d H:i'))]);
                            }
                    }else if($solicitud->idTramite==7){
                            //---AMPLIACION DE FRAGANCIA
                            //Agregar fragancia al producto
                            if(CertificacionController::certificarAmpliacionFrag($solicitud,$producto,$usuarioCreacion)==false){
                                DB::connection('sqlsrv')->rollback();
                                array_push($solicitudesNo, $idsolicitud);
                                $msgSolicitudes.="<li>El producto $solicitud->noRegistro con el tramite ampliación de fragancia no se ha podido  certificar, favor contacte con Informática</li>";
                                //return response()->json(['status' => 404, 'message' => 'Error en el sistema: La solicitud '.$solicitud->numeroSolicitud.' no ha podido ser certificada, favor contacte con Informática!'],200);
                            }
                            if(!in_array($idsolicitud, $solicitudesNo,true)){
                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolCVL ?,?,?,?,?,?,?',[$solicitud->idSolicitud,$profesional->tratamiento.' '.$profesional->NOMBREPROF,$nombreTitular,$fabricante,$distribuidores,$usuarioCreacion,$this->convertFechaHora(date('Y-m-d H:i'))]);
                            }

                    }else if($solicitud->idTramite==8){
                            //AMPLIACION DE TONO
                            //Agregar fragancia al producto
                            if(CertificacionController::certificarAmpliacionTono($solicitud,$producto,$usuarioCreacion)==false){
                                DB::connection('sqlsrv')->rollback();
                                array_push($solicitudesNo, $idsolicitud);
                                $msgSolicitudes.="<li>El producto $solicitud->noRegistro con el tramite amplicación de tono no se ha podido  certificar, favor contacte con Informática</li>";
                                //return response()->json(['status' => 404, 'message' => 'Error en el sistema: La solicitud '.$solicitud->numeroSolicitud.' no ha podido ser certificada, favor contacte con Informática!'],200);;
                            }
                            if(!in_array($idsolicitud, $solicitudesNo,true)){
                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolCVL ?,?,?,?,?,?,?',[$solicitud->idSolicitud,$profesional->tratamiento.' '.$profesional->NOMBREPROF,$nombreTitular,$fabricante,$distribuidores,$usuarioCreacion,$this->convertFechaHora(date('Y-m-d H:i'))]);
                            }

                    }else if($solicitud->idTramite==11 || $solicitud->idTramite==17){
                            //CAMBIO DE FORMULA
                            //Agregar sustancias al producto
                            if(CertificacionController::certificarCambioFormulacion($solicitud,$producto,$usuarioCreacion)==false){
                                DB::connection('sqlsrv')->rollback();
                                array_push($solicitudesNo, $idsolicitud);
                                $msgSolicitudes.="<li>El producto $solicitud->noRegistro con el tramite cambio de formulación no se ha podido  certificar, favor contacte con Informática</li>";
                                //return response()->json(['status' => 404, 'message' => 'Error en el sistema: La solicitud '.$solicitud->numeroSolicitud.' no ha podido ser certificada, favor contacte con Informática!'],200);;
                            }
                            if(!in_array($idsolicitud, $solicitudesNo,true)){
                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolCVL ?,?,?,?,?,?,?',[$solicitud->idSolicitud,$profesional->tratamiento.' '.$profesional->NOMBREPROF,$nombreTitular,$fabricante,$distribuidores,$usuarioCreacion,$this->convertFechaHora(date('Y-m-d H:i'))]);
                            }

                    }else if($solicitud->idTramite==14 || $solicitud->idTramite==23){
                            //CAMBIO DE NOMBRE COMERCIAL
                            if(CertificacionController::certificarCambioNombre($solicitud,$producto,$usuarioCreacion)==false){
                                DB::connection('sqlsrv')->rollback();
                                array_push($solicitudesNo, $idsolicitud);
                                $msgSolicitudes.="<li>El producto $solicitud->noRegistro con el tramite cambio de nombre no se ha podido  certificar, favor contacte con Informática</li>";
                            }
                            if(!in_array($idsolicitud, $solicitudesNo,true)){
                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolCVL ?,?,?,?,?,?,?',[$solicitud->idSolicitud,$profesional->tratamiento.' '.$profesional->NOMBREPROF,$nombreTitular,$fabricante,$distribuidores,$usuarioCreacion,$this->convertFechaHora(date('Y-m-d H:i'))]);
                            }

                    }else if($solicitud->idTramite==16 || $solicitud->idTramite==18){
                            //AMPLIACIÓN DE PRESENTACIÓN
                            if(CertificacionController::certificarAmpleacionPresentacion($solicitud,$producto,$usuarioCreacion)==false){
                                DB::connection('sqlsrv')->rollback();
                                array_push($solicitudesNo, $idsolicitud);
                                $msgSolicitudes.="<li>El producto $solicitud->noRegistro con el tramite ampliación de presentación no se ha podido  certificar, favor contacte con Informática</li>";
                            }
                            if(!in_array($idsolicitud, $solicitudesNo,true)){
                            DB::connection('sqlsrv')->insert('EXEC POST.certificarSolCVL ?,?,?,?,?,?,?',[$solicitud->idSolicitud,$profesional->tratamiento.' '.$profesional->NOMBREPROF,$nombreTitular,$fabricante,$distribuidores,$usuarioCreacion,$this->convertFechaHora(date('Y-m-d H:i'))]);
                            }

                    }
                    if(!in_array($idsolicitud, $solicitudesNo,true)){
                            $solicitud->idEstado = 9;
                            $solicitud->usuarioModificacion = $usuarioCreacion;
                            $solicitud->save();
                            SolicitudSeguimiento::create(['idSolicitud'=>$idsolicitud,'idEstado'=>9,'seguimiento'=>'Solicitud fue certificada','usuarioCreacion'=>$usuarioCreacion]);
                    }
            }//fin array

            }//fin foreach
            DB::connection('sqlsrv')->commit();
        }
        catch (\Exception $e){
            DB::connection('sqlsrv')->rollback();

            Log::error('LogError Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            throw  $e;
            return response()->json(['status' => 404, 'message' => 'Error en el sistema!'],200);

        }
        return response()->json(['status' => 200, 'message' => $msgSolicitudes],200);
    }

    public function getDistribuidoresByProd($producto){
        $distribuidores=null;
        if(count($producto->distribuidores->pluck('idPoder'))>0){
            $distribuidores=Distribuidores::distribuidoresConcat($producto->distribuidores->pluck('idPoder'));
        }
        else if($producto->distribuidorTitular==1) {
            if ($producto->tipoTitular == 1 || $producto->tipoTitular == 2) $titular = $producto->titular12;
            else $titular = $producto->titular3;
            if (!empty($titular) || $titular != null) {
                if ($producto->tipoTitular == 3) $distribuidores = $titular->NOMBRE_PROPIETARIO;
                else $distribuidores = $titular->nombre;
            }
        }
        return $distribuidores;
    }

}
