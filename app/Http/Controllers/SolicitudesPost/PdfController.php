<?php

namespace App\Http\Controllers\SolicitudesPost;

use App\Http\Requests\SolicitudesPost\SolPostRequest;
use App\Models\SolicitudesPost\SolicitudDocumento;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\Sesion;
use App\Models\Item;
use App\Models\Cosmetico;
use App\Models\Higienico;
use App\Models\Profesional;
use App\Models\Cosmeticos\ProfesionalesCosmeticos;
use App\Models\Higienicos\ProfesionalesHigienicos;
use App\Models\SolicitudesPost\Tramite;
use App\Models\SolicitudesPost\Solicitud as SolicitudesPost;
use App\Models\SolicitudesPost\Requisito;
use App\Models\SolicitudesPost\Documento;
use App\Models\SolicitudesPost\Dictamen;
use App\Models\SolicitudesPost\DictamenBitacora;
use App\Models\SolicitudesPost\DocumentosCertificacion;
use App\Models\SolicitudesPost\SolPostEstadosSesion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Crypt;
use Validator;
use Session;
use Response;
use File;
use Config;
use Log;
use Auth;
use DB;
use Carbon\Carbon;

use PDF;

use App\Http\Controllers\CosmeticoController;
use App\Http\Controllers\HigienicoController;


class PdfController extends Controller
{
    private $pathfiles=null;

    public function __construct() {
        $this->pathfiles= Config::get('app.mapeo_files_cos');
    }

        public function herramientaDictamen($idDic){
        $idDictamen= Crypt::decrypt($idDic);
        $dictamen = Dictamen::find($idDictamen);
        $solicitud = SolicitudesPost::find($dictamen->idSolicitud);
        $data=[
            'dictamen' => $dictamen,
            'solicitud'  => $solicitud
        ];
        $usuarioCreacion= Auth::User()->idUsuario;
        try {
        $bitacora = DictamenBitacora::where('idDictamen',$idDictamen)->where('idTipo',1)->where('estado',1)->first();
        if(!empty($bitacora)){
                 if (File::isFile($bitacora->urlArchivo)){
                             try{
                                    $file = File::get($bitacora->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                             } catch (Exception $e) {
                                    return Response::download($bitacora->urlArchivo);
                             }
                }else{
                        Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF!');
                          Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF!');
                        return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }
        }else{

                $view =  \View::make('dictamenes.POST.herramientaPDF',$data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $output = $pdf->output();
                $nombreArchivo = "\HERRAMIENTA-DICTAMEN".date('d-m-Y').".pdf";
                $rutaGuardado=$this->pathfiles.'post\\'.$solicitud->idSolicitud;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new DictamenBitacora();
                            $docGen->idDictamen=$idDictamen;
                            $docGen->idTipo=1;
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = $usuarioCreacion;
                            $docGen->save();
                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("HERRAMIENTA-SOLICITUD-".$solicitud->numeroSolicitud.".pdf");
                    }catch (Exception $e) {
                            Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF!');
                            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
                            return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                    }
                }else{
                     Session::flash('msnError','¡PROBLEMAS AL GENERAR PDF!');
                      Log::warning('Error Exception PROBLEMAS AL GENERAR PDF!');
                    return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }

        }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }




    }

    public function resolucionDictamen($idDic){
        $idDictamen= Crypt::decrypt($idDic);
        $dictamen = Dictamen::find($idDictamen);
        $solicitud = SolicitudesPost::find($dictamen->idSolicitud);
        $usuarioCreacion= Auth::User()->idUsuario;
        $bitacora = DictamenBitacora::where('idDictamen',$idDictamen)->where('idTipo',2)->where('estado',1)->first();

        if(!empty($bitacora)){
                 if (File::isFile($bitacora->urlArchivo)){
                             try{
                                    $file = File::get($bitacora->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                             } catch (Exception $e) {
                                    return Response::download($bitacora->urlArchivo);
                             }
                }else{
                        Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF!');
                        return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }

        }else{
                    //CONSULTAMOS TITULAR Y PROFESIONAL
                    if($solicitud->tipoProducto=='COS'){
                        $cos = Cosmetico::where('idCosmetico',$solicitud->noRegistro)->select('tipoTitular','idTitular')->first();
                        if($cos->tipoTitular==3){
                            if(!empty($cos->titular3)){
                                $titular = $cos->titular3->NOMBRE_PROPIETARIO;
                            }else{
                                $titular = '';
                            }
                        }else{
                            if(!empty($cos->titular12)){
                                $titular = $cos->titular12->nombre;
                            }else{
                                $titular = '';
                            }

                        }
                        $pro=ProfesionalesCosmeticos::where('idCosmetico',$solicitud->noRegistro)->first();
                        if(!empty($pro)){
                            $profesional=$pro->profesional->NOMBRES.' '.$pro->profesional->APELLIDOS;
                        }else{
                            $profesional='';
                        }

                    }else{
                        $hig = Higienico::where('idHigienico',$solicitud->noRegistro)->select('tipoTitular','idTitular')->first();
                        if($hig->tipoTitular==3){
                            if(!empty($hig->titular3)){
                                $titular = $hig->titular3->NOMBRE_PROPIETARIO;
                            }else{
                                $titular = '';
                            }
                        }else{
                            if(!empty($hig->titular12)){
                                $titular = $hig->titular12->nombre;
                            }else{
                                $titular = '';
                            }

                        }
                        $pro=ProfesionalesHigienicos::where('idHigienico',$solicitud->noRegistro)->first();
                        if(!empty($pro)){
                            $profesional=$pro->profesional->NOMBRES.' '.$pro->profesional->APELLIDOS;
                        }else{
                            $profesional='';
                        }

                    }
                    $data = [
                        'profesional' => $profesional,
                        'titular' => $titular,
                        'dictamen' => $dictamen,
                        'solicitud'  => $solicitud
                    ];
                    $dias=$this->numAletras(date('d',strtotime($dictamen->fechaCreacion)));
                    $year=$this->numAletras(date('Y',strtotime($dictamen->fechaCreacion)));
                    $hora=$this->numAletras(date('H',strtotime($dictamen->fechaCreacion)));
                    $min=$this->numAletras(date('i',strtotime($dictamen->fechaCreacion)));
                    $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

                    $data['dias']= $dias." de ".$meses[date('n',strtotime($dictamen->fechaCreacion))-1]." del ".$year;
                    $data['year']=$year;
                    $data['mes']=$meses[date('n',strtotime($dictamen->fechaCreacion))-1];
                    $data['fecha']="a las ".$hora.' horas '.$min." minutos del día ".$dias." de ".$meses[date('n',strtotime($dictamen->fechaCreacion))-1]." del ".$year;


                    if($dictamen->idEstado==4)
                    {
                        //DICTAMEN OBSERVADO
                        $view =  \View::make('dictamenes.POST.observado',$data)->render();
                    }elseif ($dictamen->idEstado==5){
                        //DICTAMEN DESFAVORABLE
                        $view =  \View::make('dictamenes.POST.desfavorable',$data)->render();
                    }
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadHTML($view);

                    $output = $pdf->output();
                    $nombreArchivo = "\RESOLUCION-DICTAMEN-".date('d-m-Y').".pdf";
                    $rutaGuardado=$this->pathfiles.'post\\'.$solicitud->idSolicitud;
                    if(file_exists($rutaGuardado)){
                        try{
                                $docGen = new DictamenBitacora();
                                $docGen->idDictamen=$idDictamen;
                                $docGen->idTipo=2;
                                $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                                $docGen->usuarioCreacion = $usuarioCreacion;
                                $docGen->save();
                                file_put_contents($rutaGuardado.$nombreArchivo, $output);
                                return $pdf->stream("RESOLUCION-SOLICITUD-".$solicitud->numeroSolicitud.".pdf");
                        }catch (Exception $e) {
                                Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF!');
                                Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
                                return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                        }
                    }else{
                         Session::flash('msnError','¡PROBLEMAS AL GENERAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL GENERAR PDF!');
                        return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                    }


       }

    }


    public function pdfCertificacion(Request $request){

        try {
            $solicitud = SolicitudesPost::findOrFail(Crypt::decrypt($request->idSolicitud));
            $usuarioCreacion= Auth::User()->idUsuario;
            if(!empty($solicitud->documentocertificacionFav)){
                if (File::isFile($solicitud->documentocertificacionFav->urlArchivo)){
                        try{
                                    $file = File::get($solicitud->documentocertificacionFav->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                        } catch (Exception $e) {
                                    return Response::download($solicitud->documentocertificacionFav->urlArchivo);
                        }
                }else{
                        Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF  CERTIFICACION FAVORABLE!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF CERTIFICACION FAVORABLE!');
                        return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }
            }else{
                if($solicitud->tramite->idTramite==1 || $solicitud->tramite->idTramite==21 || $solicitud->tramite->idTramite==22){
                    $solicitud->fechaModificacionText = $this->convertDateToText($solicitud->fechaModificacion);
                    $view =  \View::make('postRegistro.pdf.certificacion',['solicitud' => $solicitud])->render();
                }else{
                    $view =  \View::make('postRegistro.pdf.cvl',['solicitud' => $solicitud])->render();
                }

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $output = $pdf->output();
                $nombreArchivo = "\CERTIFICACION-FAVORABLE".date('d-m-Y')." ".rand(1,100).".pdf";
                $rutaGuardado=$this->pathfiles.'post\\'.$solicitud->idSolicitud;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new DocumentosCertificacion();
                            $docGen->idSolicitud=$solicitud->idSolicitud;
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = $usuarioCreacion;
                            $docGen->tipoDocumento=3;
                            $docGen->save();
                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("CERTIFICACION-SOLICITUD-".$solicitud->numeroSolicitud.".pdf");
                    }catch (Exception $e) {
                            Session::flash('msnError','¡PROBLEMAS CON LA CARPETA DE LA SOLICITUD!');
                            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
                            return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                    }
                }else{
                     Session::flash('msnError','¡PROBLEMAS AL GENERAR  PDF CERTIFICACION POST!');
                      Log::warning('Error Exception PROBLEMAS AL GENERAR PDF CERTIFICACION FAVORABLE POST CON LA SOLICITUD '.Crypt::decrypt($request->idSolicitud));
                    return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }

            }
        }
        catch (\Exception $e){
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }
    }

    public function pdfCertificacionDesfavorable(Request $request){

        try {
            $solicitud = SolicitudesPost::findOrFail(Crypt::decrypt($request->idSolicitud));
            $usuarioCreacion= Auth::User()->idUsuario;
            if(!empty($solicitud->documentocertificacionDesfav)){
                if (File::isFile($solicitud->documentocertificacionDesfav->urlArchivo)){
                        try{
                                    $file = File::get($solicitud->documentocertificacionDesfav->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                        } catch (Exception $e) {
                                    return Response::download($solicitud->documentocertificacionDesfav->urlArchivo);
                        }
                }else{
                        Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF  CERTIFICACION DESFAVORABLE!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF CERTIFICACION DESFAVORABLE!');
                        return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }
            }else{

                    $fecha = $this->convertFechaHora(date('d-m-Y H:i:s'));
                    $dia = $this->convertDateToText(date('d-m-Y'));
                    $sesion =Sesion::getSesionSolicitudPost($solicitud->idSolicitud);
                    if(empty($sesion)){
                       Session::flash('msnError','¡LA SOLICITUD NO ESTA INGRESADA EN NINGUNA SESIÓN!');
                       Log::warning('Error Exception LA SOLICITUD POST'.Crypt::decrypt($request->idSolicitud).' NO ESTA INGRESADA EN NINGUNA SESIÓN PARA GENERAR CERTIFICACION DESFAVORABLE ');
                       return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                    }
                    /*$estsol=SolPostEstadosSesion::latestEstadoSolicitud($solicitud->idSolicitud);
                    $idDictamen=$estsol[0]->idDictamen;*/
                    $dictamen = Dictamen::latestDictamenSolicitud($solicitud->idSolicitud);

                   //CONSULTAMOS  Y PROFESIONAL
                    if($solicitud->tipoProducto=='COS'){
                        $pro=ProfesionalesCosmeticos::where('idCosmetico',$solicitud->noRegistro)->first();
                        if(!empty($pro)){
                            $infoPro=Profesional::getTratamientoProfesional($pro->profesional->ID_PROFESIONAL);
                            $profesional=$infoPro->tratamiento.' '.$infoPro->NOMBREPROF;
                        }else{
                            $profesional='';
                        }

                    }else{
                        $pro=ProfesionalesHigienicos::where('idHigienico',$solicitud->noRegistro)->first();
                        if(!empty($pro)){
                            $infoPro=Profesional::getTratamientoProfesional($pro->profesional->ID_PROFESIONAL);
                            $profesional=$infoPro->tratamiento.' '.$infoPro->NOMBREPROF;
                        }else{
                            $profesional='';
                        }

                    }
                $data=[
                    'solicitud'=>$solicitud,
                    'sesion'=>$sesion,
                    'fecha'=>$fecha,
                    'profesional'=>$profesional,
                    'dictamen'=>$dictamen,
                    'dias'=>$dia
                ];



                $view =  \View::make('dictamenes.POST.desfavorable',$data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $output = $pdf->output();
                $nombreArchivo = "\CERTIFICACION-DESFAVORABLE".date('d-m-Y')." ".rand(1,100).".pdf";
                $rutaGuardado=$this->pathfiles.'post\\'.$solicitud->idSolicitud;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new DocumentosCertificacion();
                            $docGen->idSolicitud=$solicitud->idSolicitud;
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = $usuarioCreacion;
                            $docGen->tipoDocumento=5;
                            $docGen->save();
                            //CAMBIAMOS ESTADO A LA SOLICITUD A "DENEGADO"
                            $solicitud->idEstado=15;
                            $solicitud->usuarioModificacion=$usuarioCreacion;
                            $solicitud->save();

                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("CERTIFICACION-SOLICITUD-".$solicitud->numeroSolicitud.".pdf");
                    }catch (Exception $e) {
                            Session::flash('msnError','¡PROBLEMAS CON LA CARPETA DE LA SOLICITUD POST '.$solicitud->idSolicitud);
                            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
                            return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                    }
                }else{
                     Session::flash('msnError','¡PROBLEMAS AL GENERAR  PDF CERTIFICACION DESFAVORALE POST!');
                      Log::warning('Error Exception PROBLEMAS AL GENERAR PDF CERTIFICACION DESFAVORALE POST CON LA SOLICITUD '.Crypt::decrypt($request->idSolicitud));
                    return redirect()->action('SolicitudesPost\SolicitudesPostController@adminSolicitudes');
                }

            }
        }
        catch (\Exception $e){
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }
    }

    public function cambiarEstadoDocCertificacion(Request $request){
            $rules = [
                'idSolicitud'       => 'required',
                'tipoDocumento'     => 'required',
            ];
            $messages =  [
                'idSolicitud.required'      => 'Debe de ingresar el número de solicitud',
                'tipoDocumento.required'      => 'Debe de ingresar el tipo de documento',
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
        try{
             //CAMBIAMOS ESTADO A LOS DOCUMENTOS GENERADOS
            //Tipo de documento, nos indica si  es una certificacion favorable o desfavorable
            $idSolicitud= $request->idSolicitud;
            $usuarioModificacion=Auth::User()->idUsuario;
            $solicitud = SolicitudesPost::find($idSolicitud);
            if($request->tipoDocumento==3){
                //CERTIFICACION FAVORABLE
                $solicitud->documentocertificacionFav->update(['estado'=>0,'usuarioModificacion'=>$usuarioModificacion]);
            }else{
               //CERTIFICACION DESDAVORABLE
                $solicitud->documentocertificacionDesfav->update(['estado'=>0,'usuarioModificacion'=>$usuarioModificacion]);
            }
            return response()->json(['status' => 200,'message' => '¡Se actualizo la información correctamente!','idSolicitud'=>Crypt::Encrypt($idSolicitud)]);

        } catch(Exception $e){
            throw $e;
            return response()->json(['status' => 404,'message' => 'Error, problemas al realizar la consulta!']);
        }
    }







}

