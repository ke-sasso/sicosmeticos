<?php

namespace App\Http\Controllers;

use App\Models\Cat\ArchivoExpediente;
use App\Models\Cat\ProductoExpediente;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Validator;
use Session;
use App\Models\Dictamen;
use App\Models\DetalleDictamen;
use App\Models\Resolucion;
use App\Models\Solicitud;
use App\Models\Item;
use DB;
use Redirect;
use PDF;
use Carbon\Carbon;
use App\Models\SolicitudesDetalle;
use App\Models\SolicitudesSesion;
use App\Models\DetalleCosmetico;
use App\Models\Sesion;
use Yajra\Datatables\Datatables;
use App\Models\Cosmetico;
use App\Models\SolicitudesFragancias;
use App\Models\SolicitudesTonos;
use App\Models\Fabricantes;
use App\Models\Importadores;
use App\Models\SolicitudesPresentaciones;
use App\Models\Distribuidores;
use App\Models\Cosmeticos\FabricantesCosmeticos;
use App\Models\Cosmeticos\FormulaCosmeticos;
use App\Models\Cosmeticos\FraganciasCosmeticos;
use App\Models\Cosmeticos\ImportadoresCosmeticos;
use App\Models\Cosmeticos\TonosCosmeticos;
use App\Models\Cosmeticos\PresentacionesCosmeticos;
use App\Models\Cosmeticos\ProfesionalesCosmeticos;
use App\Models\Cosmeticos\DistribuidoresCosmeticos;
use App\Models\Higienico;
use App\Models\Pais;
use App\Models\Propietario;
use App\Models\Profesional;
use App\Models\DetalleHigienico;
use App\Models\Coempaques;
use App\Models\FormulaCosmetico;
use App\Models\FormulaHigienico;
use App\Models\DetalleCoempaques;
use App\Models\SolicitudesPre\SeguimientoSolPre;
use App\Models\SolicitudesPre\SolEstadosSesion;
use App\Models\Higienicos\FabricantesHigienicos;
use App\Models\Higienicos\FraganciasHigienicos;
use App\Models\Higienicos\ImportadoresHigienicos;
use App\Models\Higienicos\TonosHigienicos;
use App\Models\Higienicos\PresentacionesHigienicos;
use App\Models\Higienicos\ProfesionalesHigienicos;
use App\Models\Higienicos\DistribuidoresHigienicos;
use App\Models\Higienicos\FormulaHigienicos;
use App\Models\VwPropietario;
use App\Models\SolicitudesPre\DocumentoCertifcacion;
use Datetime;
use File;
use Date;
use Log;
use Crypt;
use Config;
use Response;
class SesionController extends Controller
{
  private $pathfiles=null;
	public function __construct()
	{
		 ini_set('max_execution_time', '-1');//tiempo ilimitado de ejecucion, lo determinanos pasandole -1
     ini_set('memory_limit', '-1');//para aumentar memoria de subida
     $this->pathfiles= Config::get('app.mapeo_files_cos');
	}

	public function getIndex(){
		$data=['title'=>'ADMINISTRADOR DE SESIONES',
          'subtitle'=>''];
        $ruta="dt.row.data.sesiones"; //index de sesiones para agregar solicitudes por técnico
        $data['ruta']=$ruta;
        $data['idTipo']=1;
        return view('sesiones.indexSesiones',$data);
     }

    public function indexSesiones(){
    	$data=['title'=>'ADMINISTRADOR DE SESIONES',
          'subtitle'=>''];
        $ruta="dt.row.data.sesiones.aprobar"; //Index para aprobar solicitudes de la sesión por el jefe
       // return view('sesiones.indexSesionesAprobar',$data);
        $data['ruta']=$ruta;
        $data['idTipo']=1;
        return view('sesiones.indexSesiones',$data);

    }

    public function getIndexCertificar(){
		$data=['title'=>'ADMINISTRADOR DE SESIONES',
          'subtitle'=>''];
        $ruta="dt.row.data.sesiones.certificar"; //index de sesiones para agregar certificar solicitudes de sesion
        $data['ruta']=$ruta;
        $data['idTipo']=1;
        return view('sesiones.indexSesiones',$data);
	}

	public function getSesiones(){
		 $sesiones=Sesion::getSesiones();
			 	return Datatables::of($sesiones)
	            ->addColumn('nombreSesion',function($dt){
	            	if($dt->estadoSesion=='EN CURSO'){
	             	 	return '<a href="'.route('verSesion',['nombreSesion'=>$dt->nombreSesion]).'" class="btn btn-primary btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
	            	} else {
	            		 return '<a href="'.route('consultarSolicitudes',['nombreSesion'=>$dt->nombreSesion]).'" class="btn btn-warning btn-sm"><b>'.$dt->nombreSesion.'</b></a>';

	            	}
	            	})->rawColumns(['nombreSesion'])
	            ->make(true);

	}

	public function getSesionesAprobar(){
    	$sesiones=Sesion::getSesiones();
			 	return Datatables::of($sesiones)
	            ->addColumn('nombreSesion',function($dt){
	            	if($dt->estadoSesion=='EN CURSO'){
	             	 	return '<a href="'.route('indexSolicitudesAprobar',['nombreSesion'=>$dt->nombreSesion]).'" class="btn btn-primary btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
	            	} else {
	            		 return '<a href="'.route('consultarSolicitudes',['nombreSesion'=>$dt->nombreSesion]).'" class="btn btn-warning btn-sm"><b>'.$dt->nombreSesion.'</b></a>';

	            	}
	            	})->rawColumns(['nombreSesion'])
	            ->make(true);


    }

	public function getSesionesCertificaciones(){
		$sesiones=Sesion::getSesiones();
			 	return Datatables::of($sesiones)
	            ->addColumn('nombreSesion',function($dt){
	             	return '<a href="'.route('getSolicitudesCertificar',['nombreSesion'=>$dt->nombreSesion]).'" class="btn btn-primary btn-sm"><b>'.$dt->nombreSesion.'</b></a>';
	            	})->rawColumns(['nombreSesion'])
	            ->make(true);
	}

    public function getDetalleSesion($idSesion){
     	  $data=['title'=>'ADMINISTRADOR DE SOLICITUDES FAVORABLES PARA LA SESIÓN '.$idSesion,
          'subtitle'=>''];
          $data['sesion']=$idSesion;
        //  dd($data['sesion']);
          return view('solicitudes.indexSolicitudesFavorables',$data);
     }

    public function agregarSolSesion(Request $request){  //método que agrega las solicitudes a sesión con aprobacion del técnico
    // dd($request);



        $data=['title'=>'ADMINISTRADOR DE SESIONES',
          'subtitle'=>''];
        $id=Sesion::getIdSesion($request->nomsesion);
   		$data['sesion']=$request->nomsesion;
        DB::connection('sqlsrv')->beginTransaction();
    	try{
	         for($i=0;$i<count($request->sol);$i++){
		        $solSesiones= new SolicitudesSesion();
		        $solSesiones->idSesion=$id[0]->idSesion;
		        $solSesiones->idSolicitud=$request->sol[$i];
		        $solSesiones->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
		        $solSesiones->estadoSolSesion=0;
            $solSesiones->tipoSolicitud=1;
		        $solSesiones->save();

		        $sol= Solicitud::find($request->sol[$i]);
		        $sol->estado=6;
		        $sol->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
		        $sol->save();
            SeguimientoSolPre::create(['idSolicitud'=>$request->sol[$i],'idEstado'=>6,'seguimiento'=>'Solicitud ingresada para aprobación a sesión','usuarioCreacion'=>Auth::User()->idUsuario.'@'.$request->ip()]);
		     }

		       	Session::flash('message','Se ingresaron solicitudes con éxito');
          }  catch(Exception $e){
	            DB::connection('sqlsrv')->rollback();
	            throw $e;
	            Session::flash($e->getMessage());
	            return back();
        }

        DB::connection('sqlsrv')->commit();
        return view('solicitudes.indexSolicitudesFavorables',$data);
     }

    public function indexSolSesiones($idSesion){
    	$data=['title'=>'ADMINISTRADOR DE SOLICITUDES FAVORABLES PARA LA SESIÓN '.$idSesion,
          'subtitle'=>''];
        $data['sesion']=$idSesion;
        //  dd($data['sesion']);
          return view('sesiones.indexSolicitudesListasSesion',$data);
    }

    public function solParaAprobar(Request $request){
    	$solicitudes=Sesion::getSolicitudesParaAprobar($request->idsesion);
          return Datatables::of($solicitudes)
           ->addColumn('idSolicitud',function($dt){
              return '<a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><b>'.$dt->idSolicitud.'</b></a>';
            })
            ->addColumn('agregar',function($dt){
	            if($dt->estadoSolSesion==0){
	              return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';
		          } else {
		          	return '';
		          }
            })->rawColumns(['idSolicitud','agregar'])
            ->make(true);
    }

    public function aprobarSolicitudes(Request $request){
    	$data=['title'=>'ADMINISTRADOR DE SESIONES',
          'subtitle'=>''];
        $id=Sesion::getIdSesion($request->nomsesion);

        DB::connection('sqlsrv')->beginTransaction();
    	try{
	         for($i=0;$i<count($request->sol);$i++){
		        $solSesion= SolicitudesSesion::where('idSolicitud',$request->sol[$i])->where('tipoSolicitud',1)->first();
		        $solSesion->estadoSolSesion=1;
		        $solSesion->idUsuarioModifica=Auth::User()->idUsuario.'@'.$request->ip();
		        $solSesion->save();

		        $sol=Solicitud::find($request->sol[$i]);
		        $sol->estado=7;
		        $sol->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
		        $sol->save();

            SeguimientoSolPre::create(['idSolicitud'=>$request->sol[$i],'idEstado'=>7,'seguimiento'=>'Solicitud ingresada a sesión','usuarioCreacion'=>Auth::User()->idUsuario.'@'.$request->ip()]);
		     }

		       	Session::flash('message','Se aprobaron solicitudes con éxito');
          }  catch(Exception $e){
	            DB::connection('sqlsrv')->rollback();
	            throw $e;
	            Session::flash($e->getMessage());
	            return back();
        }

        DB::connection('sqlsrv')->commit();

        //return view('sesiones.indexSesionesAprobar',$data);
        $ruta="dt.row.data.sesiones.aprobar"; //Index para aprobar solicitudes de la sesión por el jefe
        $data['ruta']=$ruta;
        $data['idTipo']=1;
        return view('sesiones.indexSesiones',$data);

    }

    public function getConsultarSol($idSesion){
    	$data=['title'=>'SOLICITUDES EN SESIONES',
          'subtitle'=>''];
           $data['sesion']=$idSesion;
        return view('sesiones.indexConsultarSolicitudes',$data);
    }

    public function getSolictudesByEstado(Request $request){
    //	dd($request->idsesion);
    	$solicitudes=Sesion::getSolicitudesSesion($request->idsesion);
    	//dd($solicitudes);
          return Datatables::of($solicitudes)
           ->addColumn('idSolicitud',function($dt){
              return '<a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><b>'.$dt->idSolicitud.'</b></a>';
            })->rawColumns(['idSolicitud'])
            ->make(true);

    }

    public function getDetalleSolCertificar($nomSesion){
    	  $data=['title'=>'ADMINISTRADOR DE SOLICITUDES A CERTIFICAR DE LA SESIÓN'.$nomSesion,
          'subtitle'=>''];
          $data['sesion']=$nomSesion;

        // dd($data['sesion']);
          return view('sesiones.indexSolicitudesCertificar',$data);
    }

    public function getSolCertificar(Request $request){
    	$solicitudes=Sesion::getSolicitudesParaCertificar($request->idsesion);
    	//dd($solicitudes);
           return Datatables::of($solicitudes)
           ->addColumn('idSolicitud',function($dt){
              return '<a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><b>'.$dt->idSolicitud.'</b></a>';
            })
            ->addColumn('certificar',function($dt){

              //FAVORABLE
                        if($dt->solestado==8){
                          return '<button type="button" class="btn btn-xs btn-info coempaque"  data-toggle="modal" data-target="#coemp" id="agregarcoempaque" name="agregarcoempaque" onclick="modalCoempaque('.$dt->idSolicitud.');">Agregar Coempaque</button>';
                        } else if ($dt->solestado==9) {
                          $doc=DocumentoCertifcacion::docCertificacionFavorable($dt->idSolicitud);
                          if(!empty($doc)){
                              return '<button type="button" onclick="printCert('.$dt->idSolicitud.');" class="btn btn-success btn-sm"><b>Imprimir</b></button><button type="button" onclick="actualizarDocumento('.$dt->idSolicitud.',3);" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Volver a generar documento"><b><i class="fa fa-refresh"></i></b></button>';
                          }else{
                              return '<button type="button" onclick="printCert('.$dt->idSolicitud.');" class="btn btn-success btn-sm"><b>Imprimir</b></button>';
                          }
                        } else {
                          return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';
                        }


              /*$estadoLaste=SolEstadosSesion::latestEstadoSolicitud($dt->idSolicitud);
              if(count($estadoLaste)>0){
                    if($estadoLaste[0]->idEstado=='5'){
                      //DESFAVORABLE
                        if($dt->solestado==7){
                           //EN SESION
                          return '<a target="_blank" href="'.route('solpre.pdf.certificacion.desfavorable',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'"  class="btn btn-danger btn-sm">DENEGAR</a>';
                        }else{
                           //DENEGADO
                           $doc=DocumentoCertifcacion::docCertificacionDesfavorable($dt->idSolicitud);
                            if(!empty($doc)){
                              return '<a target="_blank" href="'.route('solpre.pdf.certificacion.desfavorable',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'"  class="btn btn-success btn-sm">Imprimir</a><button type="button" onclick="actualizarDocumento('.$dt->idSolicitud.',5);" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Volver a generar documento"><b><i class="fa fa-refresh"></i></b></button>';
                            }else{
                                 return '<a target="_blank" href="'.route('solpre.pdf.certificacion.desfavorable',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'"  class="btn btn-success btn-sm">Imprimir</a>';
                            }
                        }

                    }else{
                      //FAVORABLE
                        if($dt->solestado==8){
                          return '<button type="button" class="btn btn-xs btn-info coempaque"  data-toggle="modal" data-target="#coemp" id="agregarcoempaque" name="agregarcoempaque" onclick="modalCoempaque('.$dt->idSolicitud.');">Agregar Coempaque</button>';
                        } else if ($dt->solestado==9) {
                          $doc=DocumentoCertifcacion::docCertificacionFavorable($dt->idSolicitud);
                          if(!empty($doc)){
                              return '<button type="button" onclick="printCert('.$dt->idSolicitud.');" class="btn btn-success btn-sm"><b>Imprimir</b></button><button type="button" onclick="actualizarDocumento('.$dt->idSolicitud.',3);" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Volver a generar documento"><b><i class="fa fa-refresh"></i></b></button>';
                          }else{
                              return '<button type="button" onclick="printCert('.$dt->idSolicitud.');" class="btn btn-success btn-sm"><b>Imprimir</b></button>';
                          }
                        } else {
                          return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';
                        }

                    }
              }else{
                return '<span class="label label-warning">SOLICITUD SIN ESTADO</span>';

              }*/
            })->rawColumns(['idSolicitud','certificar'])
            ->make(true);

    }

    public function certificarSolicitudes(Request $request){
		$rules = [
            'nomsesion'      => 'required',
            'sol'           => 'required|array',
		];
		 $messages =  [
            'nomsesion.required'      => 'ID sesion es requerido',
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
		 $solicitudesNo=[];
		 $sesion=Sesion::where('nombreSesion',$request->nomsesion)->first();
		 $fechaSesion=str_pad(date('my',strtotime($sesion->fechaSesion)),4,'0',STR_PAD_LEFT); // Formato de la fecha con mes y año de la fecha de la sesión
		 $msgSolicitudes='';
		 
    try{
			DB::connection('sqlsrv')->beginTransaction();
			$valcert=0;
			$valerror=0;
	        for($i=0;$i<count($request->sol);$i++){
				$val=0;
				$msgpersonales='';
				$sol=Solicitud::find($request->sol[$i]);
				if($sol->estado!=7){
					$val=$val+1;
					$msgpersonales.="<li>No posee el estado correspondiente para certificar</li>";
				}
				if(empty($sol->detallesolicitud)){
					$val=$val+1;
					$msgpersonales.="<li>No posee detalle de solicitud</li>";
				}else{
					if(empty($sol->detallesolicitud->idProfesional)){
						$val=$val+1;
						$msgpersonales.="<li>No posee ningún id profesional</li>";
					}
					if(empty($sol->detallesolicitud->idPoderProfesional)){
						$val=$val+1;
						$msgpersonales.="<li>No posee ningún poder profesional</li>";
					}
				}
				if(count($sol->fabricante)==0){
					$val=$val+1;
					$msgpersonales.="<li>Debe de poseer al menos un fabricante</li>";
				}else{
					$origen = "U";
					$idPaisOrigen = 222;
					if($sol->fabricante[0]->tipoFabricante==2){
						$origen = "E";
						$fab = Fabricantes::getFabricantes([$sol->fabricante[0]->idFabricante]);
						if(empty($fab)){
							$val=$val+1;
							$msgpersonales.="<li>No se encuentra información del fabricante asociado $sol->fabricante[0]->idFabricante</li>";
						}else{
							$idPaisOrigen = $fab[0]->codigoIdPais;	
						}
					}
				}
				/*if(count($sol->distribuidores)==0){
					$val=$val+1;
					$msgpersonales.="<li>Debe de poseer al menos un distribuidor</li>";
				}
				if(count($sol->fragancias)==0){
					$val=$val+1;
					$msgpersonales.="<li>Debe de poseer al menos una fragancia</li>";
				}
				if(count($sol->tonos)==0){
					$val=$val+1;
					$msgpersonales.="<li>Debe de poseer al menos un tono</li>";
				}
				if(count($sol->presentaciones)==0){
					$val=$val+1;
					$msgpersonales.="<li>Debe de poseer al menos una presentación</li>";
				}
				if($sol->tipoSolicitud==2||$sol->tipoSolicitud==3){
				       //COSMÉTICOS --  NO ES OBLIGATORIO QUE TENGA UN DISTRIBUIDOR
						if(count($sol->formulaCos)==0){
							$val=$val+1;
							$msgpersonales.="<li>Debe de poseer al menos una formula</li>";
						}
				}else{
				        //HIGIÉNICOS -- CUANDO ES HIG DEBE DE POSEER AL MENOS UN DISTRIBUIDOR
						if(count($sol->formulaHig)==0){
							$val=$val+1;
							$msgpersonales.="<li>Debe de poseer al menos una formula</li>";
						}
						if(count($sol->importadores)==0){
							$val=$val+1;
							$msgpersonales.="<li>Debe de poseer al menos un importador</li>";
						}
				}*/
				if($val>0){
					$msgSolicitudes.="Para la solicitud  <b>$sol->numeroSolicitud</b>:<br>".$msgpersonales;
					array_push($solicitudesNo, $sol->idSolicitud);
					$valerror=$valerror+1;
				}

				if(!in_array($sol->idSolicitud, $solicitudesNo,true)){
					$valcert=$valcert+1;
					if($sol->tipoSolicitud==2||$sol->tipoSolicitud==3){
						//-------------COSMÉTICOS-------------------------
						if($sol->tipoSolicitud==3){  
							$tipoReconocimiento=SesionController::getTipoReconocimiento($sol->detallesolicitud->idPais);            //busco el tipo de reconocimiento por pais y es RC porque es reconocimiento Cosmetico
							$tipoRec="RC".$tipoReconocimiento."%";
							$correlativo=Cosmetico::obtenerCorrelativoRec($tipoRec,date('Y',strtotime($sesion->fechaCreacion)));
						}else{
							$correlativo=Cosmetico::obtenerCorrelativoCos(date('Y',strtotime($sesion->fechaSesion)));
						}
						if(!isset($correlativo)){
							$correlativo="0001";
						}elseif(strlen($correlativo->correlativo) < 5){
							$correlativo = str_pad($correlativo->correlativo,4,'0',STR_PAD_LEFT);
						}else{
							$correlativo = $correlativo->correlativo;
						}

						$cos= new Cosmetico();
						if($sol->tipoSolicitud==3){    //Si es reconocimiento
							$numeroRegistro="RC".$tipoReconocimiento.$correlativo.$fechaSesion;
							$cos->tipo = 2;
							$cos->numeroReconocimiento=$sol->detallesolicitud->numeroRegistroExtr;
							$cos->nombreCVL=$sol->detallesolicitud->nombreCVL;
							$cos->VencimientoRec=$sol->detallesolicitud->fechaVencimiento;
							$cos->renovacion=$sol->detallesolicitud->fechaVencimiento;
						}elseif($sol->tipoSolicitud==2){
							$numeroRegistro="1".$origen."C".$correlativo.$fechaSesion; // 1 por que es registro sanitario y C porque es cosmetico
							$cos->renovacion=date('Y-m-d', strtotime($sesion->fechaSesion.'+5 year'));
							$cos->tipo = 1;
						} 
						$cos->idCosmetico=$numeroRegistro;
						$cos->nombreComercial=$sol->detallesolicitud->nombreComercial;
						$cos->estado='A';
						$cos->idMarca=$sol->detallesolicitud->idMarca;
						$cos->idPaisOrigen=$idPaisOrigen;
						$cos->tipoTitular=$sol->detallesolicitud->tipoTitular;
						$cos->idTitular=$sol->detallesolicitud->idTitular;
						$cos->vigenciaHasta=date('Y-m-d', strtotime('Dec 31'));
						$cos->idClasificacion=$sol->detallesolicitud->detallecosmetico->idClasificacion;
						$cos->idForma=$sol->detallesolicitud->detallecosmetico->idFormaCosmetica;
						$cos->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
						if($sol->distribuidorTitular==1)  $cos->distribuidorTitular=1;
						$cos->save();
			        }else{
						//-------------HIGIÉNICO-------------------------
						if($sol->tipoSolicitud==5){    
							$tipoReconocimiento=SesionController::getTipoReconocimiento($sol->detallesolicitud->idPais); //busco el tipo de reconocimiento por pais y es RC porque es reconocimiento Cosmetico
							$tipoRec="RH".$tipoReconocimiento."%";
							$correlativo=Cosmetico::obtenerCorrelativoRec($tipoRec,date('Y',strtotime($sesion->fechaCreacion)));
						}else{
							$correlativo=Higienico::obtenerCorrelativoCos(date('Y',strtotime($sesion->fechaSesion)));
						}
						if(!isset($correlativo)){
							$correlativo="0001";
						}elseif(strlen($correlativo->correlativo) < 5){
							$correlativo = str_pad($correlativo->correlativo,4,'0',STR_PAD_LEFT);
						}else{
							$correlativo = $correlativo->correlativo;
						}
				
						$hig= new Higienico();
						if($sol->tipoSolicitud==5){    
							$numeroRegistro="RH".$tipoReconocimiento.$correlativo.$fechaSesion;                                          //Si es reconocimiento
							$hig->tipo = 2;
							$hig->numeroReconocimiento=$sol->detallesolicitud->numeroRegistroExtr;
							$hig->nombreCVL=$sol->detallesolicitud->nombreCVL;
							$hig->VencimientoRec=$sol->detallesolicitud->fechaVencimiento;
							$hig->renovacion=$sol->detallesolicitud->fechaVencimiento;
						}elseif($sol->tipoSolicitud==4){
							$numeroRegistro="1".$origen."H".$correlativo.$fechaSesion;   // 1 por que es registro sanitario y C porque es cosmetico
							$hig->renovacion=date('Y-m-d', strtotime($sesion->fechaSesion.'+5 year'));
							$hig->tipo = 1;
						}
						$hig->idHigienico=$numeroRegistro;
						$hig->nombreComercial=$sol->detallesolicitud->nombreComercial;
						$hig->estado='A';
						$hig->idMarca=$sol->detallesolicitud->idMarca;
						$hig->idPaisOrigen=$idPaisOrigen;
						$hig->tipoTitular=$sol->detallesolicitud->tipoTitular;
						$hig->idTitular=$sol->detallesolicitud->idTitular;
						$hig->vigenteHasta=date('Y-m-d', strtotime('Dec 31'));
						$hig->idClasificacion=$sol->detallesolicitud->detallehigienico->idClasificacion;
						$hig->uso=$sol->detallesolicitud->detallehigienico->uso;
						$hig->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
						if($sol->distribuidorTitular==1)  $hig->distribuidorTitular=1;
						$hig->save();
					}//CIERRE TIPO SOLICITUD
					// -----------------------------------------------------------------------------------------------
					//CAMBIO DE ESTADO LAS SOLICITUDES EN LA SESION
					$solSesion=  SolicitudesSesion::where('idSolicitud',$sol->idSolicitud)->where('tipoSolicitud',1)->first(); 
					$solSesion->estadoSolSesion=2;
					$solSesion->idUsuarioModifica=Auth::user()->idUsuario.'@'.$request->ip();
					$solSesion->save();
		
					//CAMBIO DE ESTADO SOLICITUD Y ID PRODUCTO
					$sol->idProducto=$numeroRegistro;
					$sol->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
					if($sol->poseeCoempaque=='1'){
						$sol->estado=8; //pendiente de coempaque
						SeguimientoSolPre::create(['idSolicitud'=>$sol->idSolicitud,'idEstado'=>8,'seguimiento'=>'Solicitud tiene pendiente coempaque','usuarioCreacion'=>Auth::User()->idUsuario.'@'.$request->ip()]);
					} else {
						$sol->estado=9;
						SeguimientoSolPre::create(['idSolicitud'=>$sol->idSolicitud,'idEstado'=>9,'seguimiento'=>'Solicitud certificada','usuarioCreacion'=>Auth::User()->idUsuario.'@'.$request->ip()]);
					}
					$sol->save();
					DB::connection('sqlsrv')->insert('EXEC SOL.detalleCrearProducto ?,?',[$sol->idSolicitud,Auth::user()->idUsuario.'@'.$request->ip()]);
					
				
					
		        }//CIERRA VALIDACIÓN DE SOLICITUD EN ARRAY solicitudesNo

			}//CIERRE FOR
			DB::connection('sqlsrv')->commit();
			if($valcert>0 && $valerror>0){
				$msgSolicitudes.="<br>¡LAS DEMÁS SOLICITUDES FUERON CERTIFICADAS CON EXITO!";
			}elseif($valcert>0){
				$msgSolicitudes.="¡SOLICITUDES CERTIFICADAS CON EXITO!<br>";
			}
			return response()->json(['status' => 200, 'message' => $msgSolicitudes],200);
		} catch(\Illuminate\Database\QueryException $ex){ 
			DB::connection('sqlsrv')->rollback();
			Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e.$e->getLine().$e->getFile()]);
			return response()->json(['status' => 404, 'message' => '¡Problemas al certificar solicitudes, contactar con informática!'],200);

		}catch(\Exception $e){
			DB::connection('sqlsrv')->rollback();
			Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e.$e->getLine().$e->getFile()]);
			return response()->json(['status' => 404, 'message' => '¡Problemas al certificar solicitudes, contactar con informática!'],200);
		}

    }

    public function prepararCertificado(Request $rq)
    {
        $fuente = $rq->tamanio.'px';
        $sol=Solicitud::find($rq->idSolicitud);
        $id=Sesion::getIdSesion($rq->sesion);
    	  $sesion=Sesion::find($id[0]->idSesion);
        $idSolicitud = $sol->idSolicitud;
        $doc=DocumentoCertifcacion::docCertificacionFavorable($idSolicitud);
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
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF DE CERTIFICACION  FAVORABLE DE LA SOLICITUD PRE '.$idSolicitud);
                        return back();
                }
      }else{

          	$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
          	//preparan fechas de sesion y actual
          	$dias=$this->numAletras(date('d',strtotime($sesion->fechaSesion)));
      		  $year=$this->numAletras(date('Y',strtotime($sesion->fechaSesion)));
            $fechaActual=$sesion->fechaSesion;
            $dia=$this->numAletras(date('d',strtotime($fechaActual)));
      		  $año=$this->numAletras(date('Y',strtotime($fechaActual)));
            $data['fechaActual']=$dia." días del mes de ".$meses[date('n',strtotime($fechaActual))-1]." del ".$year;
      	   	$data['dia']=$dias." días del mes de ".$meses[date('n',strtotime($sesion->fechaSesion))-1]." del ".$year;
            $data['fechaSesion'] = $sesion->fechaSesion;
          	if($sol->tipoSolicitud==2||$sol->tipoSolicitud==3){
      	    	$producto=Cosmetico::find($sol->idProducto);
        			$profesional=ProfesionalesCosmeticos::find($producto->idCosmetico);
        			$fabricantes=FabricantesCosmeticos::getIDFabricantes($producto->idCosmetico);
        			$distribuidores=DistribuidoresCosmeticos::getIDdistribuidores($producto->idCosmetico);
        			$fabCosmeticos=Fabricantes::getFabricantes($fabricantes);
        			$disCosmeticos=Distribuidores::getDistribuidores($distribuidores);
        			$presentaciones=PresentacionesCosmeticos::where('idCosmetico',$producto->idCosmetico)->get();
        			$pres=$producto->presentaciones;

        			  if(count($pres)>0){
        		        for($i=0; $i<count($pres); $i++){
        		            $pres1[$i]=$producto->presentaciones->get($i)->idPresentacion;
        		        }
        		         //dd($producto);
        				    $idCoempaques=DetalleCoempaques::whereIn('idPresentacion',$pres1)->get()->pluck('idCoempaque')->toArray();
        	        	$coempaques=Coempaques::getCoempaques($idCoempaques);
        	        	//dd($coempaques);
        	        	$detalles = [];
        	        	for($i=0;$i<count($coempaques);$i++){
        	        		$detalles[$i]=Coempaques::getDetalle($coempaques[$i]->idCoempaque)->toArray();

        	        	}
        	        	$data['detalles']=$detalles;
        	     		$data['coempaques']=$coempaques;
             		}

          			if($producto->tipoTitular==1 || $producto->tipoTitular==2){
          				$prop=VwPropietario::where('nit',$producto->idTitular)->first();
          				if($prop!=null){
          					$titular=Propietario::getTitular($prop->nit, $producto->tipoTitular);
          					$titular->NOMBRE_PAIS=$titular->PAIS;
          				} else {
          					$titular=null;
          				}
          			}elseif($producto->tipoTitular == 3){
          				$titular=Propietario::getTitular($producto->idTitular,$producto->tipoTitular);
          			}
          			$data['solicitud']=$sol;
          			$data['propietario']=$titular;
          			$data['producto']=$producto;
          			$data['presentaciones']=$presentaciones;
          			$data['fabricantes']=$fabCosmeticos;
          			$data['distribuidores']=$disCosmeticos;
          			$data['fechaVencimiento'] = strtoupper(date('d',strtotime($producto->renovacion)).'-'.$meses[date('n',strtotime($producto->renovacion))-1].'-'.date('Y',strtotime($producto->renovacion)));
          			if($profesional!=null)
          				$data['profesional']=Cosmetico::getProfesionalCosmetico($profesional->idProfesional);
          			else
          				$data['profesional']=null;

                $data['user']=Auth::User()->idUsuario;

          				if($producto->tipo==1){
                      $view =  \View::make('dictamenes.cvlRegistroPDF',['data'=>$data,'tamanioFuente'=>$fuente])->render();
          				    //$pdf=PDF::loadView('dictamenes.cvlRegistroPDF',['data'=>$data,'tamanioFuente'=>$fuente]);
          				} else {
          				   $data['tipo']='COSMETICO';
          				   $data['pais']=Pais::where('codigoId',$producto->idPaisOrigen)->first();
                     $view =  \View::make('dictamenes.cvlReconocimientoPDF',['data'=>$data,'tamanioFuente'=>$fuente])->render();
          				   //$pdf=PDF::loadView('dictamenes.cvlReconocimientoPDF',['data'=>$data,'tamanioFuente'=>$fuente]);
          				}

      		}else{
      			    $producto=Higienico::find($sol->idProducto);
      	        $profesional=ProfesionalesHigienicos::find($producto->idHigienico);
      	        $fabricantes=FabricantesHigienicos::where('idHigienico',$producto->idHigienico)->select('idFabricante')->pluck('idFabricante');
      	        $distribuidores=DistribuidoresHigienicos::where('idHigienico',$producto->idHigienico)->select('idPoder')->pluck('idPoder');
      	        $fabHigienico=Fabricantes::getFabricantes($fabricantes);
      	        $disHigienico=Distribuidores::getDistribuidores($distribuidores);
      	        $presentaciones=PresentacionesHigienicos::where('idHigienico',$producto->idHigienico)->get();

      	        if($producto->tipoTitular==1 || $producto->tipoTitular==2){
      				        $prop=VwPropietario::where('nit',$producto->idTitular)->first();
            				if($prop!=null){
            					$titular=Propietario::getTitular($prop->nit, $producto->tipoTitular);
            					$titular->NOMBRE_PAIS=$titular->PAIS;
            				} else {
            					$titular=null;
            				}
      			    }elseif($producto->tipoTitular == 3){
      				     $titular=Propietario::getTitular($producto->idTitular,$producto->tipoTitular);
      			    }

          			$data['solicitud']=$sol;
          			$data['propietario']=$titular;
          			$data['producto']=$producto;
          			$data['presentaciones']=$presentaciones;
          			$data['fabricantes']=$fabHigienico;
          			$data['distribuidores']=$disHigienico;
          			$data['profesional']=Profesional::getProfesional($profesional->idProfesional);
          			$data['fechaVencimiento'] = strtoupper(date('d',strtotime($producto->renovacion)).'-'.$meses[date('n',strtotime($producto->renovacion))-1].'-'.date('Y',strtotime($producto->renovacion)));
          			$data['user']=Auth::User()->idUsuario;

      			      	if($producto->tipo==1){
                      $view =  \View::make('dictamenes.cvlRegistroPDF',['data'=>$data,'tamanioFuente'=>$fuente])->render();
      			        	//$pdf=PDF::loadView('dictamenes.cvlRegistroPDF',['data'=>$data,'tamanioFuente'=>$fuente]);
      			        } else {
      				        $data['tipo']='HIGIENICO';
      				       	$data['pais']=Pais::where('codigoId',$producto->idPaisOrigen)->first();
                      $view =  \View::make('dictamenes.cvlReconocimientoPDF',['data'=>$data,'tamanioFuente'=>$fuente])->render();
      				      	//$pdf=PDF::loadView('dictamenes.cvlReconocimientoPDF',['data'=>$data,'tamanioFuente'=>$fuente]);
      			        }

      		}

                //GUARDAMOS LA CERTIFICACION FAVORABLE
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);
                $output = $pdf->output();
                $nombreArchivo = "\CERTIFICACION-FAVORABLE-".date('d-m-Y').' '.rand(1,100).".pdf";
                $rutaGuardado=$this->pathfiles.$idSolicitud;
                if(file_exists($rutaGuardado)){
                    try{
                            $docGen = new DocumentoCertifcacion();
                            $docGen->idSolicitud=$idSolicitud;
                            $docGen->tipoDocumento=3;//FAVORABLE
                            $docGen->urlArchivo = $rutaGuardado.$nombreArchivo;
                            $docGen->usuarioCreacion = Auth::User()->idUsuario;
                            $docGen->save();

                            file_put_contents($rutaGuardado.$nombreArchivo, $output);
                            return $pdf->stream("CERTIFICACION-FAVORABLE-".$sol->numeroSolicitud.".pdf");
                    }catch (Exception $e) {
                        Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL GUARDAR PDF DE CERTIFICACION FAVORABLE DE LA SOLICITUD PRE '.$idSolicitud);
                        return back();
                    }
                }else{
                     Session::flash('message','¡PROBLEMAS AL CONSULTAR PDF!');
                     Log::warning('Error Exception PROBLEMAS CON GENERAR CERTIFICACION FAVORABLE DE LA SOLICITUD PRE '.$idSolicitud);
                    return back();
                }


      }


    }


 //********************************************************************************************************

    public function certificacionesSeleccion($request){
 	//dd(count($request->sol));
 	$data=[];


    for($i=0;$i<count($request->sol);$i++){

		$sol=Solicitud::find($request->sol[$i]);
    	//dd($sol);
    	//$sol=Solicitud::find($idSol);
    	//$id=Sesion::getIdSesion($idSesion);
    	$id=Sesion::getIdSesion($request->nomsesion);

	    $sesion=Sesion::find($id[0]->idSesion);
    	$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

    	//preparan fechas de sesion y actual
    	$dias=$this->numAletras(date('d',strtotime($sesion->fechaSesion)));
		$year=$this->numAletras(date('Y',strtotime($sesion->fechaSesion)));

		$fechaActual=$sesion->fechaSesion;
		$dia=$this->numAletras(date('d',strtotime($fechaActual)));
		$año=$this->numAletras(date('Y',strtotime($fechaActual)));

		$data[$i]['fechaActual']=$dia." días del mes de ".$meses[date('n',strtotime($fechaActual))-1]." del ".$year;
	 	$data[$i]['dia']=$dias." días del mes de ".$meses[date('n',strtotime($sesion->fechaSesion))-1]." del ".$year;
	 	//dd($sol->tipoSolicitud);
    	if($sol->tipoSolicitud==2||$sol->tipoSolicitud==3){
	    	$producto=Cosmetico::find($sol->idProducto);

			$profesional=ProfesionalesCosmeticos::find($producto->idCosmetico);
			//dd($profesional);

			$fabricantes=FabricantesCosmeticos::getIDFabricantes($producto->idCosmetico);
			$distribuidores=DistribuidoresCosmeticos::getIDdistribuidores($producto->idCosmetico);
			$fabCosmeticos=Fabricantes::getFabricantes($fabricantes);
			$disCosmeticos=Distribuidores::getDistribuidores($distribuidores);
			$presentaciones=PresentacionesCosmeticos::where('idCosmetico',$producto->idCosmetico)->get();
			$pres=$producto->presentaciones;

	        for($j=0; $j<count($pres); $j++){
	            $pres1[$j]=$producto->presentaciones->get($j)->idPresentacion;

	        }
			$idCoempaques=DetalleCoempaques::whereIn('idPresentacion',$pres1)->get()->pluck('idCoempaque')->toArray();
        	$coempaques=Coempaques::getCoempaques($idCoempaques);
        	//dd($coempaques);
        	$detalles = [];
        	for($j=0;$j<count($coempaques);$j++){
        		$detalles[$j]=Coempaques::getDetalle($coempaques[$j]->idCoempaque)->toArray();

        	}
        	$data[$i]['detalles']=$detalles;
     		$data[$i]['coempaques']=$coempaques;
			if($producto->tipoTitular==1 || $producto->tipoTitular==2)
			{
				$prop=VwPropietario::where('nit',$producto->idTitular)->first();

				if($prop!=null){
					$titular=Propietario::getTitular($prop->nit, $producto->tipoTitular);
					$titular->NOMBRE_PAIS=$titular->PAIS;
				} else {
					$titular=null;
				}
			//dd($titular);
			}
			elseif($producto->tipoTitular == 3)
			{
				$titular=Propietario::getTitular($producto->idTitular,$producto->tipoTitular);
				//dd($titular);
			}

			$data[$i]['solicitud']=$sol;
			$data[$i]['propietario']=$titular;
			$data[$i]['producto']=$producto;
			$data[$i]['presentaciones']=$presentaciones;
			$data[$i]['fabricantes']=$fabCosmeticos;
			$data[$i]['distribuidores']=$disCosmeticos;
			$data[$i]['fechaVencimiento'] = strtoupper(date('d',strtotime($producto->renovacion)).'-'.$meses[date('n',strtotime($producto->renovacion))-1].'-'.date('Y',strtotime($producto->renovacion)));
			if($profesional!=null)
				$data[$i]['profesional']=Cosmetico::getProfesionalCosmetico($profesional->idProfesional);
			else
				$data[$i]['profesional']=null;

			$data[$i]['user']=Auth::User()->idUsuario;
			$data[$i]['sesion']=$request->nomsesion;

			if($producto->tipo==2){
			     $data[$i]['tipo']='COSMETICO';
			    $data[$i]['pais']=Pais::where('codigoId',$producto->idPaisOrigen)->first();
			}

		}
		else
		{
			$producto=Higienico::find($sol->idProducto);
	        $profesional=ProfesionalesHigienicos::find($producto->idHigienico);
	        $fabricantes=FabricantesHigienicos::where('idHigienico',$producto->idHigienico)->select('idFabricante')->pluck('idFabricante');
	        $distribuidores=DistribuidoresHigienicos::where('idHigienico',$producto->idHigienico)->select('idPoder')->pluck('idPoder');
	        $fabHigienico=Fabricantes::getFabricantes($fabricantes);
	        $disHigienico=Distribuidores::getDistribuidores($distribuidores);
	        $presentaciones=PresentacionesHigienicos::where('idHigienico',$producto->idHigienico)->get();

	        if($producto->tipoTitular==1 || $producto->tipoTitular==2)
			{
				$prop=VwPropietario::where('nit',$producto->idTitular)->first();
				if($prop!=null){
					$titular=Propietario::getTitular($prop->nit, $producto->tipoTitular);
					$titular->NOMBRE_PAIS=$titular->PAIS;
				} else {
					$titular=null;
				}


			//

			}
			elseif($producto->tipoTitular == 3)
			{
				$titular=Propietario::getTitular($producto->idTitular,$producto->tipoTitular);

				//dd($producto);
			}

			$data[$i]['solicitud']=$sol;
			$data[$i]['propietario']=$titular;
			$data[$i]['producto']=$producto;
			$data[$i]['presentaciones']=$presentaciones;
			$data[$i]['fabricantes']=$fabHigienico;
			$data[$i]['distribuidores']=$disHigienico;
			$data[$i]['profesional']=Profesional::getProfesional($profesional->idProfesional);
			$data[$i]['fechaVencimiento'] = strtoupper(date('d',strtotime($producto->renovacion)).'-'.$meses[date('n',strtotime($producto->renovacion))-1].'-'.date('Y',strtotime($producto->renovacion)));
			$data[$i]['user']=Auth::User()->idUsuario;
			$data[$i]['sesion']=$request->nomsesion;
		      	if($producto->tipo==2){
		      		$data[$i]['tipo']='HIGIENICO';
			       	$data[$i]['pais']=Pais::where('codigoId',$producto->idPaisOrigen)->first();

		     	}
		}
		//$prueba[$i]=$sol->idProducto;
		//dd($prueba[$i]);
	}

	//dd($data[0]['solicitud']->tipoSolicitud);


	$pdf=PDF::loadView('dictamenes.cvlCertificadosPDF',['data'=>$data,'tamanioFuente'=>'14px']);
	return $pdf->stream('cvl.pdf');


}

    public function imprimirCertificados(Request $request){

        try {
        	$solicitudes=Sesion::getSolicitudesCertificadas($request->sesion);
         	//dd(count($solicitudes));
         	$data=[];

         	//dd(count($solicitudes));
            for($i=0;$i<count($solicitudes);$i++)
            {

        		$sol=Solicitud::find($solicitudes[$i]->idSolicitud);

            	//$sol=Solicitud::find($idSol);
            	//$id=Sesion::getIdSesion($idSesion);
            	$id=Sesion::getIdSesion($request->sesion);

        	    $sesion=Sesion::find($id[0]->idSesion);
            	$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

            	//preparan fechas de sesion y actual
            	$dias=$this->numAletras(date('d',strtotime($sesion->fechaSesion)));
        		$year=$this->numAletras(date('Y',strtotime($sesion->fechaSesion)));

        		$fechaActual=$sesion->fechaSesion;
        		$dia=$this->numAletras(date('d',strtotime($fechaActual)));
        		$año=$this->numAletras(date('Y',strtotime($fechaActual)));

        		$data[$i]['fechaActual']=$dia." días del mes de ".$meses[date('n',strtotime($fechaActual))-1]." del ".$year;
        	 	$data[$i]['dia']=$dias." días del mes de ".$meses[date('n',strtotime($sesion->fechaSesion))-1]." del ".$year;
        	 	//dd($sol->tipoSolicitud);

            	if($sol->tipoSolicitud==2||$sol->tipoSolicitud==3){
        	    	$producto=Cosmetico::find($sol->idProducto);

        			$profesional=ProfesionalesCosmeticos::find($producto->idCosmetico);

        			$fabricantes=FabricantesCosmeticos::getIDFabricantes($producto->idCosmetico);
        			$distribuidores=DistribuidoresCosmeticos::getIDdistribuidores($producto->idCosmetico);
        			$fabCosmeticos=Fabricantes::getFabricantes($fabricantes);
        			$disCosmeticos=Distribuidores::getDistribuidores($distribuidores);
        			$presentaciones=PresentacionesCosmeticos::where('idCosmetico',$producto->idCosmetico)->get();
        			$pres=$producto->presentaciones;

        			if(count($pres)>0){
        		        for($j=0; $j<count($pres); $j++){
        		            $pres1[$j]=$producto->presentaciones->get($j)->idPresentacion;
        		        }
        				    $idCoempaques=DetalleCoempaques::whereIn('idPresentacion',$pres1)->get()->pluck('idCoempaque')->toArray();
        	        	$coempaques=Coempaques::getCoempaques($idCoempaques);
        	        	//dd($coempaques);
        	        	$detalles = [];
        	        	for($j=0;$j<count($coempaques);$j++){
        	        		$detalles[$j]=Coempaques::getDetalle($coempaques[$j]->idCoempaque)->toArray();

        	        	}
        	        	$data[$i]['detalles']=$detalles;
        	     		  $data[$i]['coempaques']=$coempaques;
             		}

        			if($producto->tipoTitular==1 || $producto->tipoTitular==2)
        			{
        				$prop=VwPropietario::where('nit',$producto->idTitular)->first();
        				if($prop!=null){
        					$titular=Propietario::getTitular($prop->nit, $producto->tipoTitular);
        					$titular->NOMBRE_PAIS=$titular->PAIS;
        				} else {
        					$titular=null;
        				}


        			//

        			}
        			elseif($producto->tipoTitular == 3)
        			{
        				$titular=Propietario::getTitular($producto->idTitular,$producto->tipoTitular);

        				//dd($producto);
        			}

        			$data[$i]['solicitud']=$sol;
        			$data[$i]['propietario']=$titular;
        			$data[$i]['producto']=$producto;
        			$data[$i]['presentaciones']=$presentaciones;
        			$data[$i]['fabricantes']=$fabCosmeticos;
        			$data[$i]['distribuidores']=$disCosmeticos;
        			$data[$i]['fechaVencimiento'] = strtoupper(date('d',strtotime($producto->renovacion)).'-'.$meses[date('n',strtotime($producto->renovacion))-1].'-'.date('Y',strtotime($producto->renovacion)));

        			//dd(Cosmetico::getProfesionalCosmetico($profesional->idProfesional));
        			if($profesional!=null)
        				$data[$i]['profesional']=Cosmetico::getProfesionalCosmetico($profesional->idProfesional);
        			else
        				$data[$i]['profesional']=null;
        			$data[$i]['user']=Auth::User()->idUsuario;
        			$data[$i]['sesion']=$request->nomsesion;

        			if($producto->tipo==2){
        			     $data[$i]['tipo']='COSMETICO';
        			    $data[$i]['pais']=Pais::where('codigoId',$producto->idPaisOrigen)->first();
        			}

        		}
        		else
        		{
        			$producto=Higienico::find($sol->idProducto);
        			//dd(ProfesionalesHigienicos::find($producto->idHigienico));
        	        $profesional=ProfesionalesHigienicos::find($producto->idHigienico);
        	        $fabricantes=FabricantesHigienicos::where('idHigienico',$producto->idHigienico)->select('idFabricante')->pluck('idFabricante');
        	        $distribuidores=DistribuidoresHigienicos::where('idHigienico',$producto->idHigienico)->select('idPoder')->pluck('idPoder');
        	        $fabHigienico=Fabricantes::getFabricantes($fabricantes);
        	        $disHigienico=Distribuidores::getDistribuidores($distribuidores);
        	        $presentaciones=PresentacionesHigienicos::where('idHigienico',$producto->idHigienico)->get();

        	        if($producto->tipoTitular==1 || $producto->tipoTitular==2)
        			{
        				$prop=VwPropietario::where('nit',$producto->idTitular)->first();
        				if($prop!=null){
        					$titular=Propietario::getTitular($prop->nit, $producto->tipoTitular);
        					$titular->NOMBRE_PAIS=$titular->PAIS;
        				} else {
        					$titular=null;
        				}


        			//

        			}
        			elseif($producto->tipoTitular == 3)
        			{
        				$titular=Propietario::getTitular($producto->idTitular,$producto->tipoTitular);

        				//dd($producto);
        			}

        			$data[$i]['solicitud']=$sol;
        			$data[$i]['propietario']=$titular;
        			$data[$i]['producto']=$producto;
        			$data[$i]['presentaciones']=$presentaciones;
        			$data[$i]['fabricantes']=$fabHigienico;
        			$data[$i]['distribuidores']=$disHigienico;
        			$data[$i]['profesional']=Profesional::getProfesional($profesional->idProfesional);
        			$data[$i]['fechaVencimiento'] = strtoupper(date('d',strtotime($producto->renovacion)).'-'.$meses[date('n',strtotime($producto->renovacion))-1].'-'.date('Y',strtotime($producto->renovacion)));
        			$data[$i]['user']=Auth::User()->idUsuario;
        			$data[$i]['sesion']=$request->nomsesion;
        		      	if($producto->tipo==2){
        		      		$data[$i]['tipo']='HIGIENICO';
        			       	$data[$i]['pais']=Pais::where('codigoId',$producto->idPaisOrigen)->first();

        		     	}
        		}
        	}//fin For

        	$fuente=$request->fuente.'px';

        	$pdf=PDF::loadView('dictamenes.cvlCertificadosPDF',['data'=>$data,'tamanioFuente'=>$fuente]);
        	return $pdf->stream('cvl.pdf');

   }catch(Exception $e){
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            //throw $e;
            return "PROBLEMAS AL GENERAR PDF";
    }

}

    public function getTipoReconocimiento($idPais){
    	if($idPais==320)         //GUATEMALA
    		$tipo="G";
    	else if($idPais==558)     //NICARAGUA
    		$tipo="N";
        else if ($idPais==340)     //HONDURAS
        	$tipo="H";
        else if ($idPais==188)     //COSTA RICA
        	$tipo="C";
        else if ($idPais==591)     //PANAMA
        	$tipo="P";
        else $tipo ="";
        return $tipo;
    }

    public function crearExpediente($solicitud,$user){
        //primero crear la carpeta del producto
        //dd(Storage::disk('coshig')->getDriver()->getAdapter()->getPathPrefix());

        DB::connection('sqlsrv')->beginTransaction();

        try {
            $filesystem= new Filesystem();
            $pathsource=Storage::disk('coshig')->getDriver()->getAdapter()->getPathPrefix().$solicitud->idSolicitud;
            $pathdest=Storage::disk('coshigexpedientes')->getDriver()->getAdapter()->getPathPrefix();
            $files=$solicitud->detalleDocumentos;
            if($filesystem->exists($pathdest) && $filesystem->exists($pathsource)){
                if ($filesystem->isWritable($pathdest)) {
                    File::makeDirectory($pathdest.$solicitud->idProducto, 0777, true, true);

                    if (!empty($files)) {
                        foreach ($files as $file){
                            $item=Item::findOrFail($file->pivot->idItemDoc);
                            $source=$pathdest.$solicitud->idProducto.'\\'.$item->nombreItem.'.pdf';
                            File::copy($file->urlArchivo,$source);
                            $archivo=ArchivoExpediente::create(['urlArchivo'=>$source,'tipoArchivo'=>$file->tipoArchivo,'usuarioCreacion'=>$user]);
                            ProductoExpediente::create(['productoId'=>$solicitud->idProducto,'archivoExpId'=>$archivo->idArchivoExp,'itemId'=>$item->idItem,'usuarioCreacion'=>$user]);
                        }
                        DB::connection('sqlsrv')->commit();
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    DB::connection('sqlsrv')->rollback();
                    return 0;
                }
            }
        }
        catch (Throwable $e) {
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            //throw $e;
            return 0;
        }
        catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            //throw $e;
            return 0;
        }
    }

     public function getProductoSesion(Request $request)
    {
      try {
        // 1.Solicitudes PRE 2. Solicitudes POST
        $rules = [
            'search'      => 'required',
            'idTipo'      => 'required',
        ];
        $messages =  [
            'search.required'      => 'Debe de ingresar un número o nombre del producto a buscar',
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
           $info = Sesion::getConsultaProducto($request->search,$request->idTipo);
           if($info){
                $msg=  "El producto ".$request->search." se encuentra en la sesión <b>".$info->nombreSesion."</b>";
                return response()->json(['status'=>200,'message' => $msg]);
           }else{
                return response()->json(['status'=>200,'message' => '¡No se encontraron resultados en su búsqueda!']);
           }
      } catch (\Exception $e) {
        return $e;
         Log::error('LOError Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
         return response()->json(['status' => 404, 'message' => '¡Problemas al consultar los datos!'],200);
      }

    }

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




















  /*public function updateSolicitudes(request $request){


  	$solicitud=Solicitud::where('idProducto','!=',null)->get();
  	//dd(count($solicitud));

    try
    {
	        for($i=0;$i<1;$i++)
	        {
		        $sol=Solicitud::find(29);
		        			 //Creo producto en catalogo

		        $detalle=SolicitudesDetalle::find($sol->idSolicitud);
		       	$distribuidores=Distribuidores::where('idSolicitud',$sol->idSolicitud)->get();
		       	$fabricantes=Fabricantes::where('idSolicitud',$sol->idSolicitud)->get();
		       	$fragancias=SolicitudesFragancias::where('idSolicitud',$sol->idSolicitud)->get();
		       	$tonos=SolicitudesTonos::where('idSolicitud',$sol->idSolicitud)->get();
		       	$pres=SolicitudesPresentaciones::where('idSolicitud',$sol->idSolicitud)->get();
		       	$importadores=Importadores::where('idSolicitud',$sol->idSolicitud)->get();
		       	$formulasCos=FormulaCosmetico::where('idSolicitud',$sol->idSolicitud)->get();
		       	$formulasHig=FormulaHigienico::where('idSolicitud',$sol->idSolicitud)->get();



		       	if(isset($sol) && $sol->estado == 9)
		       	{
			        if($sol->tipoSolicitud==2||$sol->tipoSolicitud==3)
			        {

			        	ProfesionalesCosmeticos::where('idCosmetico',$sol->idProducto)->delete();



			        	$profesional= new ProfesionalesCosmeticos();
			        	$profesional->idCosmetico=$sol->idProducto;
			        	$profesional->idProfesional=$detalle->idProfesional;
			        	$profesional->idPoder=$detalle->idPoderProfesional;
			        	$profesional->idUsuarioCrea=$sol->idUsuarioCrea;
			        	$profesional->save();




			        	DistribuidoresCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($distribuidores);$j++){                         // Guardo Distribuidores
			        		$dis= new DistribuidoresCosmeticos();
			        		$dis->idCosmetico=$sol->idProducto;
			        		$dis->idPoder=$distribuidores[$j]->idPoderDistribuidor;
			        		$dis->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$dis->save();
			        	}

			        	FabricantesCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($fabricantes);$j++){
			        		$fab= new FabricantesCosmeticos();
			        		$fab->idCosmetico=$sol->idProducto;
			        		$fab->idFabricante=$fabricantes[$j]->idFabricante;
			        		$fab->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$fab->save();
			        	}

			        	FraganciasCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($fragancias);$j++){
			        		$fra= new FraganciasCosmeticos();
			        		$fra->idCosmetico=$sol->idProducto;
			        		$fra->fragancia=$fragancias[$j]->fragancia;
			        		$fra->estado='A';
			        		$fra->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$fra->save();
			        	}

			        	TonosCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($tonos);$j++){
			        		$tono= new TonosCosmeticos();
			        		$tono->idCosmetico=$sol->idProducto;
			        		$tono->tono=$tonos[$j]->tono;
			        		$tono->estado='A';
			        		$tono->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$tono->save();
			        	}

			        	ImportadoresCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($importadores);$j++){
			        		$imp= new ImportadoresCosmeticos();
			        		$imp->idCosmetico=$sol->idProducto;
			        		$imp->idImportador=$importadores[$j]->idImportador;
			        		$imp->estado='A';
			        		$imp->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$imp->save();
			        	}

			        	PresentacionesCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($pres);$j++){
			        		$pre= new PresentacionesCosmeticos();
			        		$pre->idCosmetico=$sol->idProducto;
			        		$pre->idEnvasePrimario=$pres[$j]->idEnvasePrimario;
			        		$pre->idMaterialPrimario=$pres[$j]->idMaterialPrimario;
			        		$pre->contenidoPrimario=$pres[$j]->contenido;
			        		$pre->idUnidad=$pres[$j]->idUnidad;
			        		$pre->idEnvaseSecundario=$pres[$j]->idEnvaseSecundario;
			        		$pre->idMaterialSecundario=$pres[$j]->idMaterialSecundario;
			        		$pre->contenidoSecundario=$pres[$j]->contenidoSecundario;
			        		$pre->textoPresentacion=$pres[$j]->textoPresentacion;
			        		$pre->estado='A';
			        		$pre->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$pre->save();
			        	}

			        	FormulaCosmeticos::where('idCosmetico',$sol->idProducto)->delete();
			        	for ($j=0; $j < count($formulasCos); $j++) {
			        		$for = new FormulaCosmeticos();
			        		$for->idDenominacion=$formulasCos[$j]->idDenominacion;
			        		$for->idCosmetico=$sol->idProducto;
			        		$for->porcentaje=$formulasCos[$j]->porcentaje;
			        		$for->idUsuarioCreacion=$sol->idUsuarioCrea;
			        		$for->save();

			        	}



			     	}
			     	else
			     	{


			        	ProfesionalesHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	$profesional= new ProfesionalesHigienicos();
			        	$profesional->idHigienico=$sol->idProducto;
			        	$profesional->idProfesional=$detalle->idProfesional;
			        	$profesional->idPoder=$detalle->idPoderProfesional;
			        	$profesional->estado='A';
			        	$profesional->idUsuarioCrea=$sol->idUsuarioCrea;
			        	$profesional->save();


			        	DistribuidoresHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($distribuidores);$j++){       // Guardo Distribuidores
			        		$dis= new DistribuidoresHigienicos();
			        		$dis->idHigienico=$sol->idProducto;
			        		$dis->idPoder=$distribuidores[$j]->idPoderDistribuidor;
			        		$dis->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$dis->save();
			        	}

			        	FabricantesHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($fabricantes);$j++){
			        		$fab= new FabricantesHigienicos();
			        		$fab->idHigienico=$sol->idProducto;
			        		$fab->idFabricante=$fabricantes[$j]->idFabricante;
			        		$fab->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$fab->save();
			        	}

			        	FraganciasHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($fragancias);$j++){
			        		$fra= new FraganciasHigienicos();
			        		$fra->idHigienico=$sol->idProducto;
			        		$fra->fragancia=$fragancias[$j]->fragancia;
			        		$fra->estado='A';
			        		$fra->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$fra->save();
			        	}

			        	TonosHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($tonos);$j++){
			        		$tono= new TonosHigienicos();
			        		$tono->idHigienico=$sol->idProducto;
			        		$tono->tono=$tonos[$j]->tono;
			        		$tono->estado='A';
			        		$tono->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$tono->save();
			        	}

			        	ImportadoresHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($importadores);$j++){
			        		$imp= new ImportadoresHigienicos();
			        		$imp->idHigienico=$sol->idProducto;
			        		$imp->idImportador=$importadores[$j]->idImportador;
			        		$imp->estado='A';
			        		$imp->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$imp->save();
			        	}

			        	PresentacionesHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for($j=0;$j<count($pres);$j++){
			        		$pre= new PresentacionesHigienicos();
			        		$pre->idHigienico=$sol->idProducto;
			        		$pre->idEnvasePrimario=$pres[$j]->idEnvasePrimario;
			        		$pre->idMaterialPrimario=$pres[$j]->idMaterialPrimario;
			        		$pre->contenidoPrimario=$pres[$j]->contenido;
			        		$pre->idUnidad=$pres[$j]->idUnidad;
			        		$pre->idEnvaseSecundario=$pres[$j]->idEnvaseSecundario;
			        		$pre->idMaterialSecundario=$pres[$j]->idMaterialSecundario;
			        		$pre->contenidoSecundario=$pres[$j]->contenidoSecundario;
			        		$pre->textoPresentacion=$pres[$j]->textoPresentacion;
			        		$pre->estado='A';
			        		$pre->idUsuarioCrea=$sol->idUsuarioCrea;
			        		$pre->save();
			        	}

			        	FormulaHigienicos::where('idHigienico',$sol->idProducto)->delete();
			        	for ($j=0; $j < count($formulasHig); $j++) {
			        		$for = new FormulaHigienicos();
			        		$for->idDenominacion=$formulasHig[$j]->idDenominacion;
			        		$for->idHigienico=$sol->idProducto;
			        		$for->porcentaje=$formulasHig[$j]->porcentaje;
			        		$for->idUsuarioCreacion=$sol->idUsuarioCrea;
			        		$for->save();

			        	}



	          		}

	          	}

        	}

        	return view('welcome');
	}
	catch(\Exception $e)
	{
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        Session::flash($e->getMessage());
	        return back();
	}

    }*/

}