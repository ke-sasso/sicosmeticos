<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\Dictamen;
use App\Models\DetalleDictamen;
use App\Models\Resolucion;
use App\Models\Solicitud;
use App\Models\Propietario;
use App\Models\VwPropietario;
use Validator;
use DB;
use Log;
use Redirect;
use Mail;
use File;
use Config;
use PDF;
use Crypt;
use Response;
use Yajra\Datatables\Datatables;
use App\Models\SolicitudesPre\SeguimientoSolPre;
use App\Models\SolicitudesDetalle;
use App\Models\Sesion;
use App\Models\SolicitudesPre\SolEstadosSesion;
use App\Models\SolicitudesPre\DocumentoCertifcacion;
use App\Models\SolicitudesPre\BitacoraDocDictamen;

class DictamenController extends Controller
{
    private $pathfiles=null;
    public function __construct() {
        $this->pathfiles= Config::get('app.mapeo_files_cos');
    }
	  public static function nuevoDictamen($idSol){
    	$data=['title'=>'Dictamen',
    			'subtitle'=>''];

        $solicitud= Solicitud::find($idSol);
    	if($solicitud->tipoSolicitud==2||$solicitud->tipoSolicitud==3){

    		$items=Dictamen::getItemsDictamenCos();
    		$apartados=Dictamen::getApartadosCos();

    	}else {
    		$items=Dictamen::getItemsDictamenHig();
    		$apartados=Dictamen::getApartadosHig();
    	}

    	$data['items']=$items;
    	$data['apartados']=$apartados;
    	$data['c']=0;
    //	$data['cont']=[1,2,4,6,8,0];
       // dd($data);
    	return view ('dictamenes.nuevoDictamenCosmetico',$data);
    }

    public function guardarDictamen(Request $request){
    	//dd($request->opcion);
    	$data=['title'=>'Resolución',
    			'subtitle'=>''];
            //      $numDictamen=10;

    	DB::connection('sqlsrv')->beginTransaction();
    	try
      {
	    	$dictamen= new Dictamen();
	    	$dictamen->idSolicitud=$request->idSolicitud;
	    	$dictamen->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
	    	$dictamen->save();

	    	$numDictamen= $dictamen;

        for($i=0;$i<count($request->opcion);$i++)
        {
          $detalleDic= new DetalleDictamen();
          $detalleDic->idDictamen=$numDictamen->idDictamen;
          $detalleDic->idItem=$request->items[$i];
          $detalleDic->opcion=$request->opcion[$i];
          if(!empty($request->txtObservacion[$i]))
          {
            $detalleDic->observaciones=$request->txtObservacion[$i];
          }
          $detalleDic->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
          $detalleDic->save();
        }

          DB::connection('sqlsrv')->commit();
          $data['numDictamen']=$numDictamen;
            Session::flash('message','Se ingreso dictamen con éxito');
          return view ('dictamenes.NuevaResolucion',$data);

	    	}
        catch(Exception $e)
        {
	            DB::connection('sqlsrv')->rollback();
	            throw $e;
	            Session::flash($e->getMessage());
	            return back();
        	}

    }

    public function guardarResolucion(Request $request){
        //dd($request);
        $data=['title'=>'Dictamen',
                'subtitle'=>''];

        DB::connection('sqlsrv')->beginTransaction();
        try{
            $resolucion= new Resolucion();
            $resolucion->idDictamen=$request->idDictamen;
            $resolucion->resolucion=$request->resolucion;
            if(!empty($request->obs)){
                $resolucion->observacion=$request->obs;
            }
            $resolucion->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
            $resolucion->save();

            $solicitud=Solicitud::find($request->idSolicitud);
            $solicitud->estado=$request->resolucion;
            $solicitud->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
            $solicitud->save();

            /*if($request->resolucion==3 || $request->resolucion==5){
              $idResol = $resolucion::all()->last()->idResolucion;
              //SE GUARDA EL ÚLTIMO ESTADO QUE TENDRA LA SOLICITUD, QUE AYUDARA PARA DETERMINAR AL MOMENTO DE CERTIFICAR O DENEGAR UNA SOLICITUD EN LA SESION
              $solest = new SolEstadosSesion();
              $solest->idSolicitud= $request->idSolicitud;
              $solest->idEstado=$request->resolucion;
              $solest->idResolucionDictamen= $idResol;
              $solest->usuarioCreacion= Auth::user()->idUsuario.'@'.$request->ip();
              $solest->save();

            }*/

            Session::flash('message','Se guardo resolución con éxito');
            DB::connection('sqlsrv')->commit();

            $observaciones=Dictamen::getItemObservados($request->idDictamen);

            $persona=Solicitud::getPersonaN($solicitud->nitSolicitante);
            $correo=$persona[0]->emailsContacto;
            $data['observaciones']=$observaciones;
            $data['solicitud']=$solicitud;

            //dd($data);
            SeguimientoSolPre::create(['idSolicitud'=>$request->idSolicitud,'idEstado'=>$request->resolucion,'seguimiento'=>'Se ingreso un nuevo dictamen.','usuarioCreacion'=>Auth::User()->idUsuario.'@'.$request->ip()]);

            /*if($request->resolucion == 4) {
                if (!empty($correo) || $correo != null || $correo != '') {
                    Mail::send('dictamenes.mailCorrespondencia', $data, function ($msj) use ($correo) {
                        $msj->subject('SOLICITUD DE PORTAL EN LINEA OBSERVADA');
                        $msj->to($correo);
                        $msj->bcc('cosmeticos.higienicos@medicamentos.gob.sv');
                    });
                }
            }*/


            return redirect()->route('pdfDictamen', [$request->idDictamen]);



        }
        catch(Exception $e)
        {
                DB::connection('sqlsrv')->rollback();
                throw $e;
                Session::flash($e->getMessage());
                return back();
        }
    }

    public function pdfDictamen($idDic){
        $data=$this->getDataHerramienta($idDic);
        $idSol=$data['solicitud'][0]->idSolicitud;

        //CONSULTAMOS SI YA EXISTE LA HERRAMIENTA PDF DEL DICTAMEN
        $docresul= BitacoraDocDictamen::documentoHerramienta($data['resolucion'][0]->idResolucion);

        if(!empty($docresul)){
              if (File::isFile($docresul->urlArchivo)){
                             try{
                                    $file = File::get($docresul->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                             } catch (Exception $e) {
                                    return Response::download($docresul->urlArchivo);
                             }
                }else{
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF HERRAMIENTA DE LA SOLICITUD PRE '.$idSol);
                        return back();
                }


        }else{
                $view =  \View::make('dictamenes.herramientaPDF',['data'=>$data])->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $output = $pdf->output();
                $nombreArchivo = "\HERRAMIENTA-DICTAMEN-".date('d-m-Y').".pdf";
                $rutaGuardado=$this->pathfiles.$idSol;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new BitacoraDocDictamen();
                            $docGen->idResolucion=$data['resolucion'][0]->idResolucion;
                            $docGen->idTipo=1;// 1. Herramienta
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = Auth::User()->idUsuario;
                            $docGen->save();

                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("HERRAMIENTA-DICTAMEN.pdf");
                    }catch (Exception $e) {
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL GUARDAR PDF DE HERRAMIENTA DE LA SOLICITUD PRE '.$idSol);
                        return back();
                    }
                }else{
                     Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                     Log::warning('Error Exception PROBLEMAS CON GENERAR PDF DE HERRAMIENTA DE LA SOLICITUD PRE '.$idSol);
                    return back();
                }


        }

    }

    public function getDataHerramienta($idDic){
        $dictamen= Dictamen::getInfoDictamen($idDic);
        $solicitud= Solicitud::find($dictamen[0]->idSolicitud);
        $detalleSol=SolicitudesDetalle::getDetalle($solicitud->idSolicitud);
        $nomTram=Solicitud::getNombreTramite($solicitud->tipoSolicitud);
        $resolucion=Resolucion::getResolucion($idDic);

        $detalleSol[0]->fechaCreacion=date('d-m-y',strtotime($detalleSol[0]->fechaCreacion));

        $resolucion[0]->fechaCreacion=date('d-m-y',strtotime($resolucion[0]->fechaCreacion));

        $profesional=Solicitud::getProfesional($detalleSol[0]->idPoderProfesional);

        $titular=Propietario::getTitular($detalleSol[0]->idTitular,$detalleSol[0]->tipoTitular);


        $data['resolucion']=$resolucion;
        $data['dictamen']=$dictamen;
        $data['solicitud']=$detalleSol;

        $data['tram']=$nomTram;
        $data['titular']=$titular;
        $data['profesional']=$profesional;


        return $data;
    }

    public function pdfResolucion($idDic){
        $data=$this->getDataHerramienta($idDic);

        $dias=$this->numAletras(date('d',strtotime($data['resolucion'][0]->fechaCreacion)));
        $year=$this->numAletras(date('Y',strtotime($data['resolucion'][0]->fechaCreacion)));
        $hora=$this->numAletras(date('H',strtotime($data['resolucion'][0]->fechaCreacion)));
        $min=$this->numAletras(date('i',strtotime($data['resolucion'][0]->fechaCreacion)));

        $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

        $data['dias']= $dias." de ".$meses[date('n',strtotime($data['resolucion'][0]->fechaCreacion))-1]." del ".$year;
        $data['year']=$year;
        $data['mes']=$meses[date('n',strtotime($data['resolucion'][0]->fechaCreacion))-1];
        $data['fecha']="a las ".$hora.' horas '.$min." minutos del día ".$dias." de ".$meses[date('n',strtotime($data['resolucion'][0]->fechaCreacion))-1]." del ".$year;

        if($data['resolucion'][0]->resolucion=="OBSERVADO")
        {
            $pdf=PDF::loadView('dictamenes.resolucionPDF',['data'=>$data]);


        }else {
          return null;
        }
           return $pdf->stream('resolucionDictamen.pdf');

    }

    public function pdfResolucionBySol($idSol,$idDic){



        $dictamen=Dictamen::getDictamenBySol($idSol,$idDic);
        $infoDic= Dictamen::getInfoDictamen($idDic);
        //dd($dictamen);
        $solicitud= Solicitud::find($dictamen->idSolicitud);
        $detalleSol=SolicitudesDetalle::getDetalle($solicitud->idSolicitud);
        $nomTram=Solicitud::getNombreTramite($solicitud->tipoSolicitud);
        $resolucion=Resolucion::getResolucion($dictamen->idDictamen);
        if(!empty($resolucion)){
            $docresul= BitacoraDocDictamen::documentoResolucion($resolucion[0]->idResolucion);
        }else{
            Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
            Log::warning('Error Exception LA SOLICITUD PRE '.$idSol.' NO TIENE RESOLUCION PARA EL DICTAMEN #'.$idDic);
            return back();
        }
        if(!empty($docresul)){
               if (File::isFile($docresul->urlArchivo)){
                             try{
                                    $file = File::get($docresul->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                             } catch (Exception $e) {
                                    return Response::download($docresul->urlArchivo);
                             }
                }else{
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF DE RESOLUCIÓN DE LA SOLICITUD PRE '.$idSol);
                        return back();
                }
        }else{
              $detalleSol[0]->fechaCreacion=date('d-m-y',strtotime($detalleSol[0]->fechaCreacion));
              $profesional=Solicitud::getProfesional($detalleSol[0]->idPoderProfesional);
              if($detalleSol[0]->tipoTitular==1 || $detalleSol[0]->tipoTitular==2){ //natural
                $titular=Solicitud::getPropietarioJuridico($detalleSol[0]->idTitular);
              }else{
                  $titular=Solicitud::getPropietarios($detalleSol[0]->idTitular);
              }
              $dias=$this->numAletras(date('d',strtotime($resolucion[0]->fechaCreacion)));
              $year=$this->numAletras(date('Y',strtotime($resolucion[0]->fechaCreacion)));
              $hora=$this->numAletras(date('H',strtotime($resolucion[0]->fechaCreacion)));
              $min=$this->numAletras(date('i',strtotime($resolucion[0]->fechaCreacion)));
              $resolucion[0]->fechaCreacion=date('d-m-y',strtotime($resolucion[0]->fechaCreacion));
              $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
              $data['fecha']="a las ".$hora.' horas '.$min." minutos del día ".$dias." de ".$meses[date('n',strtotime($resolucion[0]->fechaCreacion))-1]." del ".$year;
              //dd( $data['fecha']);
              $data['dias']= $dias." de ".$meses[date('n',strtotime($resolucion[0]->fechaCreacion))-1]." del ".$year;
              $data['year']=$year;
              $data['mes']=$meses[date('n',strtotime($resolucion[0]->fechaCreacion))-1];
              $data['resolucion']=$resolucion;
              $data['dictamen']=$dictamen;
              $data['solicitud']=$detalleSol;
              $data['numeroSolicitud']=$solicitud->numeroSolicitud;
              $data['tram']=$nomTram;
              $data['titular']=$titular;
              $data['profesional']=$profesional;
              $data['observaciones'] = $infoDic;

              //dd($data['resolucion'][0]->resolucion);
              if($data['resolucion'][0]->resolucion=="OBSERVADO"){
                 $view =  \View::make('dictamenes.resolucionPDF',['data'=>$data])->render();

              }elseif($data['resolucion'][0]->resolucion=="DESFAVORABLE"){
                  $view =  \View::make('dictamenes.desfavorablePDF',['data'=>$data])->render();

              }else{
                 return null;
              }
              //return $pdf->stream('resolucionDictamen.pdf');*/

                //$view =  \View::make('dictamenes.resolucionPDF',['data'=>$data])->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $output = $pdf->output();
                $nombreArchivo = "\RESOLUCION-DICTAMEN-".date('d-m-Y').".pdf";
                $rutaGuardado=$this->pathfiles.$idSol;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new BitacoraDocDictamen();
                            $docGen->idResolucion=$resolucion[0]->idResolucion;
                            $docGen->idTipo=2;// 2. RESOLUCION
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = Auth::User()->idUsuario;
                            $docGen->save();

                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("RESOLUCION-DICTAMEN-".$solicitud->numeroSolicitud.".pdf");
                    }catch (Exception $e) {
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL GUARDAR PDF DE RESOLUCION DE LA SOLICITUD PRE '.$idSol);
                        return back();
                    }
                }else{
                     Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                     Log::warning('Error Exception PROBLEMAS CON GENERAR PDF DE RESOLUCION DE LA SOLICITUD PRE '.$idSol);
                    return back();
                }


        }


    }
      public function pdfResolBySolDesfavorable($idSol)
    {
        $idSolicitud= Crypt::decrypt($idSol);
        $doc=DocumentoCertifcacion::docCertificacionDesfavorable($idSolicitud);

        if(!empty($doc)){
              if (File::isFile($doc->urlArchivo)){
                             try{
                                    $file = File::get($doc->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                             } catch (Exception $e) {
                                    return Response::download($doc->urlArchivo);
                             }
                }else{
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF DE CERTIFICACION DE LA SOLICITUD PRE '.$idSolicitud);
                        return back();
                }
        }else{
              $dictamen=Dictamen::getDictamenBySol($idSolicitud);
              $infoDic= Dictamen::getInfoDictamen($dictamen->idDictamen);
              $solicitud= Solicitud::find($dictamen->idSolicitud);
              $detalleSol=SolicitudesDetalle::getDetalle($solicitud->idSolicitud);
              $nomTram=Solicitud::getNombreTramite($solicitud->tipoSolicitud);
              $resolucion=Resolucion::getResolucion($dictamen->idDictamen);
              $detalleSol[0]->fechaCreacion=date('d-m-y',strtotime($detalleSol[0]->fechaCreacion));
              $profesional=Solicitud::getProfesional($detalleSol[0]->idPoderProfesional);
              $sesion =Sesion::getSesionSolicitudPre($idSolicitud);
              if($detalleSol[0]->tipoTitular==1 || $detalleSol[0]->tipoTitular==2){ //natural
                  $titular=Solicitud::getPropietarioJuridico($detalleSol[0]->idTitular);
              }else{
                  $titular=Solicitud::getPropietarios($detalleSol[0]->idTitular);
              }
              $dias=$this->numAletras(date('d',strtotime($resolucion[0]->fechaCreacion)));
              $year=$this->numAletras(date('Y',strtotime($resolucion[0]->fechaCreacion)));
              $hora=$this->numAletras(date('H',strtotime($resolucion[0]->fechaCreacion)));
              $min=$this->numAletras(date('i',strtotime($resolucion[0]->fechaCreacion)));
              $resolucion[0]->fechaCreacion=date('d-m-y',strtotime($resolucion[0]->fechaCreacion));

              $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
              $data['fecha']="a las ".$hora.' horas '.$min." minutos del día ".$dias." de ".$meses[date('n',strtotime($resolucion[0]->fechaCreacion))-1]." del ".$year;
              //dd( $data['fecha']);

              $data['dias']= $dias." de ".$meses[date('n',strtotime($resolucion[0]->fechaCreacion))-1]." del ".$year;
              $data['year']=$year;
              $data['mes']=$meses[date('n',strtotime($resolucion[0]->fechaCreacion))-1];
              $data['resolucion']=$resolucion;
              $data['dictamen']=$dictamen;
              $data['solicitud']=$detalleSol;
              $data['numeroSolicitud']=$solicitud->numeroSolicitud;
              $data['tram']=$nomTram;
              $data['titular']=$titular;
              $data['profesional']=$profesional;
              $data['observaciones'] = $infoDic;
              $data['sesion'] = $sesion;
              if (empty($sesion)){
                    Session::flash('message','LA SOLICITUD PRE '.$idSolicitud.' NO ESTA EN NINGUNA SESIÓN PARA GENERAR CERTIFICACION DESFAVORABLE');
                    Log::warning('Error Exception LA SOLICITUD PRE '.$idSolicitud.' NO ESTA EN NINGUNA SESIÓN PARA GENERAR CERTIFICACION DESFAVORABLE');
                    return back();
              }

                $view =  \View::make('dictamenes.desfavorablePDF',['data'=>$data])->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                $output = $pdf->output();
                $nombreArchivo = "\CERTIFICACION-DESFAVORABLE-".date('d-m-Y').' '.rand(1,100).".pdf";
                $rutaGuardado=$this->pathfiles.$idSolicitud;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new DocumentoCertifcacion();
                            $docGen->idSolicitud=$idSolicitud;
                            $docGen->tipoDocumento=5;//DESFAVORABLE
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = Auth::User()->idUsuario;
                            $docGen->save();

                            //CAMBIAMOS DE ESTADO A LA SOLICITUD A DENEGADO
                            $solicitud->estado=15;
                            $solicitud->idUsuarioModificacion=Auth::User()->idUsuario;
                            $solicitud->save();

                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("CERTIFICACION-DESFAVORABLE-".$solicitud->numeroSolicitud.".pdf");
                    }catch (Exception $e) {
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL GUARDAR PDF DE CERTIFICACION DESFAVORABLE DE LA SOLICITUD PRE '.$idSolicitud);
                        return back();
                    }
                }else{
                     Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                     Log::warning('Error Exception PROBLEMAS CON GENERAR CERTIFICACION DESFAVORABLE DE LA SOLICITUD PRE '.$idSolicitud);
                    return back();
                }



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
            $usuarioModifica=Auth::User()->idUsuario;
            if($request->tipoDocumento==3){
                //CERTIFICACION FAVORABLE
               DocumentoCertifcacion::where('idSolicitud',$idSolicitud)->where('tipoDocumento',3)->update(['estado'=>0,'usuarioModificacion'=>$usuarioModifica]);
            }else{
               //CERTIFICACION DESDAVORABLE
               DocumentoCertifcacion::where('idSolicitud',$idSolicitud)->where('tipoDocumento',5)->update(['estado'=>0,'usuarioModificacion'=>$usuarioModifica]);
            }
            return response()->json(['status' => 200,'message' => '¡Se actualizo la información correctamente!','idSolicitud'=>Crypt::Encrypt($idSolicitud)]);

        } catch(Exception $e){
            throw $e;
            return response()->json(['status' => 404,'message' => 'Error, problemas al realizar la consulta!']);
        }
    }



   /* public function getDataResolucion($idDic){
        $dictamen= Dictamen::getInfoDictamen($idDic);
        $solicitud= Solicitud::find($dictamen[0]->idSolicitud);
        $detalleSol=SolicitudesDetalle::getDetalle($solicitud->idSolicitud);
        $nomTram=Solicitud::getNombreTramite($solicitud->tipoSolicitud);
        $resolucion=Resolucion::getResolucion($idDic);

        $data['resolucion']=$resolucion;
        $data['dictamen']=$dictamen;
        $data['solicitud']=$detalleSol;
        $data['tram']=$nomTram;

        return $data;
    }*/
      public static function numAletras($num, $fem = false, $dec = true) //$num es el numero que recibe cualquiera los otros parametros no se para que son
  {
     $matuni[2]  = "dos";
     $matuni[3]  = "tres";
     $matuni[4]  = "cuatro";
     $matuni[5]  = "cinco";
     $matuni[6]  = "seis";
     $matuni[7]  = "siete";
     $matuni[8]  = "ocho";
     $matuni[9]  = "nueve";
     $matuni[10] = "diez";
     $matuni[11] = "once";
     $matuni[12] = "doce";
     $matuni[13] = "trece";
     $matuni[14] = "catorce";
     $matuni[15] = "quince";
     $matuni[16] = "diecis&eacute;is";
     $matuni[17] = "diecisiete";
     $matuni[18] = "dieciocho";
     $matuni[19] = "diecinueve";
     $matuni[20] = "veinte";
     $matunisub[2] = "dos";
     $matunisub[3] = "tres";
     $matunisub[4] = "cuatro";
     $matunisub[5] = "quin";
     $matunisub[6] = "seis";
     $matunisub[7] = "sete";
     $matunisub[8] = "ocho";
     $matunisub[9] = "nove";

     $matdec[2] = "veint";
     $matdec[3] = "treinta";
     $matdec[4] = "cuarenta";
     $matdec[5] = "cincuenta";
     $matdec[6] = "sesenta";
     $matdec[7] = "setenta";
     $matdec[8] = "ochenta";
     $matdec[9] = "noventa";
     $matsub[3]  = 'mill';
     $matsub[5]  = 'bill';
     $matsub[7]  = 'mill';
     $matsub[9]  = 'trill';
     $matsub[11] = 'mill';
     $matsub[13] = 'bill';
     $matsub[15] = 'mill';
     $matmil[4]  = 'millones';
     $matmil[6]  = 'billones';
     $matmil[7]  = 'de billones';
     $matmil[8]  = 'millones de billones';
     $matmil[10] = 'trillones';
     $matmil[11] = 'de trillones';
     $matmil[12] = 'millones de trillones';
     $matmil[13] = 'de trillones';
     $matmil[14] = 'billones de trillones';
     $matmil[15] = 'de billones de trillones';
     $matmil[16] = 'millones de billones de trillones';

     //Zi hack
     $float=explode('.',$num);
     $num=$float[0];

     $num = trim((string)@$num);
     if ($num[0] == '-') {
      $neg = 'menos ';
      $num = substr($num, 1);
     }else
      $neg = '';
     while ($num[0] == '0') $num = substr($num, 1);
     if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
     $zeros = true;
     $punt = false;
     $ent = '';
     $fra = '';
     for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
       if ($punt) break;
       else{
        $punt = true;
        continue;
       }

      }elseif (! (strpos('0123456789', $n) === false)) {
       if ($punt) {
        if ($n != '0') $zeros = false;
        $fra .= $n;
       }else

        $ent .= $n;
      }else

       break;

     }
     $ent = '     ' . $ent;
     if ($dec and $fra and ! $zeros) {
      $fin = ' coma';
      for ($n = 0; $n < strlen($fra); $n++) {
       if (($s = $fra[$n]) == '0')
        $fin .= ' cero';
       elseif ($s == '1')
        $fin .= $fem ? ' una' : ' un';
       else
        $fin .= ' ' . $matuni[$s];
      }
     }else
      $fin = '';
     if ((int)$ent === 0) return 'Cero ' . $fin;
     $tex = '';
     $sub = 0;
     $mils = 0;
     $neutro = false;
     while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
       $matuni[1] = 'una';
       $subcent = 'as';
      }else{
       $matuni[1] = $neutro ? 'un' : 'uno';
       $subcent = 'os';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      }elseif ($n2 < 21)
       $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {
       $n3 = $num[2];
       if ($n3 != 0) $t = 'i' . $matuni[$n3];
       $n2 = $num[1];
       $t = ' ' . $matdec[$n2] . $t;
      }else{
       $n3 = $num[2];
       if ($n3 != 0) $t = ' y ' . $matuni[$n3];
       $n2 = $num[1];
       $t = ' ' . $matdec[$n2] . $t;
      }
      $n = $num[0];
      if ($n == 1) {
       $t = ' ciento' . $t;
      }elseif ($n == 5){
       $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
      }elseif ($n != 0){
       $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
      }
      if ($sub == 1) {
      }elseif (! isset($matsub[$sub])) {
       if ($num == 1) {
        $t = ' mil';
       }elseif ($num > 1){
        $t .= ' mil';
       }
      }elseif ($num == 1) {
       $t .= ' ' . $matsub[$sub] . '?n';
      }elseif ($num > 1){
       $t .= ' ' . $matsub[$sub] . 'ones';
      }
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {
       if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
       $mils = 0;
      }
      $neutro = true;
      $tex = $t . $tex;
     }
     $tex = $neg . substr($tex, 1) . $fin;
     //Zi hack --> return ucfirst($tex);
     //$end_num=ucfirst($tex).' '.$float[1].'/100';
    // return ucfirst($tex); ucfirst es la primera letra en mayuscula
    return $tex;
  }

  public function enviarCorrespondencia(request $request){

    $recipients = explode(',',$request->emails);
   // dd(count($recipients));

       $dic=Dictamen::where('idSolicitud',$request->idsol)->get();
        $ids = array();
        //dd($dic[0]->idDictamen);

        for ($i=0; $i < count($dic); $i++) {
          $ids[$i]=$dic[$i]->idDictamen;
        }
        $dicFav=Resolucion::getDicFavorable($ids);

        //dd($dicFav[0]->idDictamen);

        try{
            $resolucion= new Resolucion();
            $resolucion->idDictamen=$dicFav[0]->idDictamen;
            $resolucion->resolucion=12;
            if(!empty($request->obs)){
                $resolucion->observacion=$request->obs;
            }
            $resolucion->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
            $resolucion->save();

            $data['observacion']=$request->obs;


              Mail::send('dictamenes.mailObservacion',$data,function($msj) use ($recipients){
              $msj->subject('Certificación lista para ser retirada');
              $msj->to($recipients);
             // $msj->bcc('cosmeticos.higienicos@medicamentos.gob.sv');
              });

            return response()->json(['status' => 200,'message' => 'Se ha enviado la correspondecia correctamente', 'data' => []]);

          }
          catch(Exception $e){
                  DB::connection('sqlsrv')->rollback();
                  throw $e;
                  return response()->json(['status' => 400,'message' => 'Error: no se envio la correspondencia', 'data' => []]);
          }


      }

      public function indexAdmonNotificaciones(){
      $data=['title'=>'Administrador de Noticicaciones',
          'subtitle'=>''];
      return view ('dictamenes.indexNotificaciones',$data);
    }

    public function getSolicitudesNotificacion()
      {

        $solicitudes=Dictamen::getSolicitudesNotificadas();

        return Datatables::of($solicitudes)
          ->addColumn('opciones',function($dt)
            {
              $opc = '<a href="'.route('registroNotificacion',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><i class="fa fa-check-square-o"></i></a>';

              return $opc;
            })->rawColumns(['opciones'])
          ->make(true);

      }

      public function registroNotificacion($idSol){
        $data=['title'=>'SOLICITUD  #'.$idSol,
          'subtitle'=>''];

        $solicitud=Solicitud::find($idSol);
        $data['sol']=$solicitud;
        $persona=Solicitud::getPersonaN($solicitud->nitSolicitante);
        $persona[0]->telefonosContacto=json_decode($persona[0]->telefonosContacto);
        $data['persona']=$persona;
       // dd($persona);

        $prop = [];
          $titular = [];

          if($solicitud->detallesolicitud->tipoTitular!=null){
            if($solicitud->detallesolicitud->tipoTitular==1 || $solicitud->detallesolicitud->tipoTitular==2)
            {

              $prop=VwPropietario::where('nit',$solicitud->detallesolicitud->idTitular)->first();
             // dd($prop);
              if($prop!=null){
                $titular=Propietario::getTitular($prop->nit,$solicitud->detallesolicitud->tipoTitular);
                $titular->telefonosContacto=json_decode($titular->telefonosContacto);
              }


            }
            elseif($solicitud->detallesolicitud->tipoTitular == 3)
            {
              $titular=Propietario::getTitular($solicitud->detallesolicitud->idTitular,$solicitud->detallesolicitud->tipoTitular);
              //dd($titular);
              if($titular!=null)
              $titular->telefonosContacto=json_decode($titular->telefonosContacto);

            }
          } else {
            $titular=null;
          }
          $data['titular']=$titular;


        return view ('dictamenes.notificacionUsuario',$data);
      }

      public function guardarNuevaNotificacion(Request $request){


        $observacion='Nombre: '.$request->nombre.', '.'NIT: '.$request->nit.', '.'Telefonos de contacto: '.$request->telefonoPersona.', '.'Email: '.$request->emailPersona;
//dd($observacion);
        $dic=Dictamen::where('idSolicitud',$request->idSol)->get();
        $ids = array();
        //dd($dic[0]->idDictamen);

        for ($i=0; $i < count($dic); $i++) {
          $ids[$i]=$dic[$i]->idDictamen;
        }
        $dicFav=Resolucion::getDicFavorable($ids);

       // dd($dicFav[0]->idDictamen);

        try{
            $resolucion= new Resolucion();
            $resolucion->idDictamen=$dicFav[0]->idDictamen;
            $resolucion->resolucion=13;
            $resolucion->observacion=$observacion;
            $resolucion->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
            $resolucion->save();


             $data=['title'=>'Administrador de Noticicaciones',
          'subtitle'=>''];
      return view ('dictamenes.indexNotificaciones',$data);

          }
          catch(Exception $e){
                  DB::connection('sqlsrv')->rollback();
                  throw $e;
                  return response()->json(['status' => 400,'message' => 'Error: no se envio la correspondencia', 'data' => []]);
          }

      }


}
