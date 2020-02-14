<?php

namespace App\Http\Controllers\SolicitudesPost;

use App\Http\Requests\SolicitudesPost\SolPostRequest;
use App\Models\Distribuidores;
use App\Models\Item;
use App\Models\SolicitudesPost\SolicitudDocumento;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Mail;
use App\Models\Solicitud as SolPre;
use App\Models\Cosmetico;
use App\Models\Higienico;
use App\Models\EstadoSolicitud;
use App\Models\SolicitudesPost\Tramite;
use App\Models\SolicitudesPost\Solicitud as SolicitudPost;
use App\Models\SolicitudesPost\Requisito;
use App\Models\SolicitudesPost\Documento;
use App\Models\SolicitudesPost\vwSolicitudes;
use App\Models\SolicitudesPost\Dictamen;
use App\Models\SolicitudesPost\DictamenDetalle;
use App\Models\SolicitudesPost\SolicitudSeguimiento;
use App\Models\SolicitudesPost\SolFragancia;
use App\Models\SolicitudesPost\SolTono;
use App\Models\SolicitudesPost\SolFechaReconocimiento;
use App\Models\SolicitudesPost\SolFormula;
use App\Models\SolicitudesPost\SolNombreComercial;
use App\Models\SolicitudesPost\FormulaDelete;
use App\Models\SolicitudesPost\SolPresentacion;
use App\Models\SolicitudesPost\PresentacionesDelete;
use App\Models\SolicitudesPost\SolPostEstadosSesion;
use App\Models\Cosmeticos\FabricantesCosmeticos;
use App\Models\Cat\ProductoExpediente;
use App\Models\Cat\ArchivoExpediente;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;


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



class SolicitudesPostController extends Controller
{
    private $pathfiles=null;

    public function __construct() {
        $this->pathfiles= Config::get('app.mapeo_files_cos');
    }

    public function nuevaSolicitud(){

        $data = ['title' => 'Nueva Solicitud post - Registro',
            'subtitle' => ''];

        try{
            $data['tramites'] = Tramite::getActivos();
        }
        catch (\Exception $e){
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            throw $e;
        }
        //dd($data['tramites']);
        return view('postRegistro.nuevaSolicitud', $data);
    }

    public function adminSolicitudes(){

        $data = ['title' => 'Administrador de Solicitudes post - Registro',
                 'subtitle' => ''];

        return view('postRegistro.adminSolicitudes', $data);
    }

    public function getDtRowSolicitudes(){
        $solicitudes = DB::table('dnm_cosmeticos_si.POST.vwSolicitudes');
        return Datatables::of(vwSolicitudes::getadministrador())
            ->addColumn('opciones',function($dt){
                    if($dt->idEstado==1){
                        return '<span class="label label-warning">PENDIENTE DE ASIGNAR</span><br><a  href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-xs btn-success" title="Ver"><i class="fa fa-search"></i></a>';
                    }elseif($dt->idEstado==2){
                        return '<a  href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-xs btn-info" title="Revisar">REVISAR</a>';
                    }else if($dt->idEstado==9){
                         return '<a  href="'.route('revisar.solicitud.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-xs btn-success" title="Ver"><i class="fa fa-search"></i></a> <a  href="'.route('certificacion.requisito.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" target="_blank" class="btn btn-xs btn-info" title="PDF"><i class="fa fa-print"></i></a>';
                    }else{
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

    public function certificarSolicitudes(){

        $data = ['title' => 'Certificación de Solicitudes Post Sin Sesión',
            'subtitle' => ''];

        return view('postRegistro.adminCertificarSol', $data);
    }

    public function getDtRowCertificarSol(){
        return Datatables::of(vwSolicitudes::certificadas())
            ->addColumn('opciones',function($dt){
                //$r1='<a  href="'.route('certificar.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" class="btn btn-xs btn-primary" title="Certificar">Certificar</a>';
                $r='';
                $r2='<a  href="'.route('solicitud.certificar.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud),'idSesion'=>Crypt::encrypt($dt->sesion)]).'" class="btn btn-xs btn-success" title="Ver"><i class="fa fa-search"></i></a>';
                $r3='<a  href="'.route('certificacion.requisito.post',['idSolicitud'=>Crypt::encrypt($dt->idSolicitud)]).'" target="_blank" class="btn btn-xs btn-info" title="PDF"><i class="fa fa-print"></i></a>';
                if($dt->idEstado==9) $r=$r3;

                return $r2.' '.$r;
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

    public function getProductos(Request $request){

        $rules = [
            'q'            =>  'sometimes',
            'tipoProducto' =>  'required'
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 400, 'message' => $msg],400);
        }

        try{
            $productos=null;
            if($request->tipoProducto==="COS"){
                if($request->has('q'))$productos=Cosmetico::getCosmeticos($request->q)->take(50)->get();
                else $productos=Cosmetico::getCosmeticos()->take(50)->get();
            }
            else if($request->tipoProducto==="HIG"){
                if($request->has('q'))$productos=Higienico::getHigienicosActivos($request->q)->take(50)->get();
                else $productos=Higienico::getHigienicosActivos()->take(50)->get();
            }


            if(empty($productos) || count($productos) <= 0 ){
                return response()->json(['status' => 404, 'message' => "No se han encontrado resultados!"],200);
            }else{
                return response()->json(['status' => 200, 'data' => $productos],200);
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }catch (Exception $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }

    public function getGeneralesProducto(Request $request){
        $rules = [
            'idProducto'   =>  'required',
            'tipoProducto' =>  'required'
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 400, 'message' => $msg],400);
        }

        try{
            $view=null;
            if($request->tipoProducto==="COS"){
                $cosmeticoController = new CosmeticoController();
                $view=$cosmeticoController->verCosmetico(Crypt::encrypt($request->idProducto),Crypt::encrypt(2));
                //$cosmetico=Cosmetico::findOrFail($request->idProducto);
                //$view = view('Cosmeticos.paneles.datosgenerales',['cos'=>$cosmetico]);
            }
            else if($request->tipoProducto==="HIG"){
                //$higienico=Higienico::findOrFail($request->idProducto);
                //$view = view('higienicos.paneles.datosgenerales',['hig'=>$higienico]);
                $higienicoController = new HigienicoController();
                $view=$higienicoController->verhigienico(Crypt::encrypt($request->idProducto),Crypt::encrypt(2));
            }

            //return (String)$view;
            if(empty($view)){
                return response()->json(['status' => 404, 'message' => "No se han encontrado resultados!"],404);
            }else{
                return response()->json(['status' => 200, 'data' => (String)$view],200);
            }
        }
        catch (\Exception $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }

    public function getDatosProducto(Request $request){
        $rules = [
            'idProducto'   =>  'required',
            'tipoProducto' =>  'required'
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 400, 'message' => $msg],400);
        }

        try{
            $view=null;
            if($request->tipoProducto==="COS"){
                $cosmetico=Cosmetico::findOrFail($request->idProducto);
                $view = view('Cosmeticos.paneles.datosgenerales',['cos'=>$cosmetico]);
            }
            else if($request->tipoProducto==="HIG"){
                $higienico=Higienico::findOrFail($request->idProducto);
                $view = view('higienicos.paneles.datosgenerales',['hig'=>$higienico]);
            }

            //return (String)$view;
            if(empty($view)){
                return response()->json(['status' => 404, 'message' => "No se han encontrado resultados!"],404);
            }else{
                return response()->json(['status' => 200, 'data' => (String)$view],200);
            }
        }
        catch (Exception $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }

    public function store(Request $request){
        //dd($request->all());
        $rules = [
            'tipoProducto'      => 'required',
            'idCosmetico'       => 'sometimes|required_if:tipoProducto,COS',
            'idHigienicos'      => 'sometimes|required_if:tipoProducto,HIG',
            'nombreComercial'   => 'required',
            'nitPersona'        => 'required',
            'idMand'            => 'required',
            'tipoTramite'       => 'required',
            'tononew'           => 'sometimes|required_if:tipoTramite,8|array|min:1',
            'fragancianew'      => 'sometimes|required_if:tipoTramite,7|array|min:1',
            'fechaReconocimiento'  => 'sometimes|required_if:tipoTramite,22',
            'idDenominacion'       => 'sometimes|required_if:tipoTramite,11|required_if:tipoTramite,17|array|min:1|',
            'nombreNuevo'          => 'sometimes|required_if:tipoTramite,14|required_if:tipoTramite,23',
            'presentaciones'       => 'sometimes|required_if:tipoTramite,16|required_if:tipoTramite,18|array|min:1|',
        ];

        $messages =  [
            'tipoProducto.required'      => 'Tipo Producto es requerido',
            'idCosmetico.required_if'    => 'No Registro Cosmètico es requerido',
            'idHigienicos.required_if'   => 'No Registro Higiénico es requerido',
            'nombreComercial.required'   => 'Nombre Comercial es requerido',
            'nitPersona.required'        => 'NIT Solicitante es requerido',
            'idMand.required'            => 'Número de mandamiento es requerido',
            'tipoTramite.required'       => 'Tipo Trámite es requerido',
            'tononew.required_if'        => 'Dede ingresar el campo tono',
            'fragancianew.required_if'   => 'Dede ingresar el campo fragancia',
            'fechaReconocimiento.required_if'   => 'Dede ingresar la fecha de vigencia del país origen',
            'idDenominacion.min'           => 'Dede ingresar una o más sustancias',
            'idDenominacion.required_if'   => 'Dede ingresar una o más sustancias',
            'nombreNuevo.required_if'       => 'Debe de ingresar el nombre comercial del producto',
            'presentaciones.required_if'    => 'Debe de ingresar una o más presentaciones',
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
        try {
            $now = Carbon::now('America/El_Salvador');
            $fechaRecepcion=$now->format('Y-m-d  H:i:s');

            $solicitud = new SolicitudPost();
            $solicitud->tipoProducto = $request->tipoProducto;
            if ($request->tipoProducto == "COS") $solicitud->noRegistro = $request->idCosmetico;
            else $solicitud->noRegistro = $request->idHigienicos;
            $solicitud->nombreComercial = $request->nombreComercial;
            $solicitud->nitSolicitante = $request->nitPersona;
            $solicitud->idMandamiento = $request->idMand;
            $solicitud->idEstado = 1;
            $solicitud->solicitudPortal = 0;
            $solicitud->idTramite = $request->tipoTramite;
            $solicitud->usuarioCreacion = $usuarioCreacion;
            $solicitud->fechaRecepcion = $fechaRecepcion;
            $solicitud->fechaEnvio = $fechaRecepcion;
            $solicitud->save();
            $idSolicitud= $solicitud::all()->last()->idSolicitud;
            $saveDocs=$this->guardarDocumentos($idSolicitud,$request->file('file-es'),$usuarioCreacion);
            if($saveDocs==0){
                DB::connection('sqlsrv')->rollback();
                return response()->json(['status' => 404, 'message' => 'Error en el sistema: No se han podido guardar los documentos adjuntos, por favor vuelva intentarlo!'],200);
            }
            if($request->tipoTramite==7){ //Fragancia new
                if($request->has('fragancianew')){
                        foreach ($request->fragancianew as $key => $fragancia) {
                            $fra = new SolFragancia();
                            $fra->fragancia = $fragancia;
                            $fra->usuarioCreacion=$usuarioCreacion;
                            $fra->idSolicitud=$idSolicitud;
                            $fra->save();
                        }
               }else{
                     DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Ingresar una o más fragancias!'],200);
               }
            }
            elseif($request->tipoTramite==8){ //Tono new
                if($request->has('tononew')){
                    foreach ($request->tononew as $key => $tono){
                        $ton = new SolTono();
                        $ton->idSolicitud=$idSolicitud;
                        $ton->tono = $tono;
                        $ton->usuarioCreacion=$usuarioCreacion;
                        $ton->save();
                    }
                }else{
                      DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Ingresar uno o más tonos!'],200);
                }

            }elseif($request->tipoTramite==22){ //fecha reconocimiento
                if($request->has('fechaReconocimiento')){
                    SolFechaReconocimiento::create(['idSolicitud'=>$idSolicitud,'fecha'=>$request->fechaReconocimiento,'usuarioCreacion'=>$usuarioCreacion]);
                }else{
                      DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Se debe de ingresar una fecha de vigencia!'],200);
                }

            }else if($request->tipoTramite==11 || $request->tipoTramite==17){
                if($request->has('idDenominacion')){
                    $iddeno=$request->idDenominacion; $ncas=$request->ncas; $nombreDenominacion=$request->nombreDenominacion; $porcentaje=$request->porcentaje;
                    foreach($iddeno as $key => $fom){
                        $formu = new SolFormula();
                        $formu->idSolicitud= $idSolicitud;
                        $formu->idDenominacion=$fom;
                        $formu->nombreDenominacion=$nombreDenominacion[$key];
                        $formu->porcentaje=$porcentaje[$key];
                        $formu->ncas=$ncas[$key];
                        $formu->usuarioCreacion=$usuarioCreacion;
                        $formu->save();
                    }
                    //formulas eliminas
                    if($request->has('deleIdIdnominacion')){
                        $dele = $request->deleIdIdnominacion;
                        $primary = $request->primaryFormula;
                        foreach($dele as $key => $formudelete){
                            $deletefor = new FormulaDelete();
                            $deletefor->idDenominacion = $formudelete;
                            $deletefor->idPrimary =$primary[$key];
                            $deletefor->idSolicitud = $idSolicitud;
                            $deletefor->usuarioCreacion = $usuarioCreacion;
                            $deletefor->save();
                        }
                    }
                }else{
                      DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Se debe de ingresar una o más sustancias!'],200);
                }
            }else if($request->tipoTramite==14 || $request->tipoTramite==23){
                if($request->has('nombreNuevo')){
                     $nomcomercial= new SolNombreComercial();
                     $nomcomercial->idSolicitud=$idSolicitud;
                     $nomcomercial->nombreNuevo=$request->nombreNuevo;
                     $nomcomercial->nombreAntiguo=$request->nombreComercial;
                     $nomcomercial->usuarioCreacion=$usuarioCreacion;
                     $nomcomercial->save();
                }else{
                     DB::connection('sqlsrv')->rollback();
                    return reponse()->json(['status'=>404,'message'=>'¡Debe de ingresar un nombre comercial!'],200);
                }
            }else if($request->tipoTramite==16 || $request->tipoTramite==18){
                if($request->has('presentaciones')){
                    foreach ($request->presentaciones as $presentacion) {
                                $present = json_decode($presentacion);
                                $solPresentacion = new SolPresentacion();
                                if(isset($present->idSolicitud)){
                                    $solPresentacion::create(json_decode($presentacion,true));
                                }
                                else {
                                    $solPresentacion->idSolicitud = $idSolicitud;
                                    $solPresentacion->idEnvasePrimario = $present->emppri;
                                    $solPresentacion->idMaterialPrimario = $present->matpri;
                                    $solPresentacion->contenidoPrimario = $present->contpri;
                                    $solPresentacion->idUnidad = $present->unidadmedidapri;
                                    if ($request->unidadmedidapri == 11) {
                                        $solPresentacion->peso = $present->idMedida;
                                        $solPresentacion->idMedida = $present->medida;
                                    }

                                    if ($present->checkempsec == 1) {
                                        $solPresentacion->idEnvaseSecundario = $present->empsec;
                                        $solPresentacion->idMaterialSecundario = $present->matsec;
                                        $solPresentacion->contenidoSecundario = $present->contsec;
                                    }

                                    $solPresentacion->nombrePresentacion = $present->nombrePres;
                                    $solPresentacion->textoPresentacion = $present->textPres;
                                    $solPresentacion->usuarioCreacion = $usuarioCreacion;
                                    $solPresentacion->save();
                                }
                    }
                    if($request->has('deleIdPresentacion')){
                        $nombre = $request->deleteTexto;
                        foreach($request->deleIdPresentacion as $key => $idpre){
                            $deletepre = new PresentacionesDelete();
                            $deletepre->idSolicitud = $idSolicitud;
                            $deletepre->idPresentacion = $idpre;
                            $deletepre->nombrePresentacion = $nombre[$key];
                            $deletepre->usuarioCreacion = $usuarioCreacion;
                            $deletepre->save();
                        }

                    }
                }else{
                     DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Ingresar uno o más presentaciones!'],200);
                }
            }
            SolicitudSeguimiento::create(['idSolicitud'=>$idSolicitud,'idEstado'=>1,'seguimiento'=>'Solicitud ingresada','usuarioCreacion'=>$usuarioCreacion]);
            DB::connection('sqlsrv')->commit();
        }
        catch (\Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('LOError Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            throw  $e;
            return back()->withInput();

        }
        return response()->json(['status' => 200, 'message' => 'Solicitud ingresada'],200);
    }

    public function guardarDocumentos($idSolicitudNew,$files,$idUsuarioCrea){
        /* FUNCION PARA GUARDAR LOS ARCHIVOS */
        DB::connection('sqlsrv')->beginTransaction();

        try {

            $npath=$this->pathfiles.'post\\';

            $filesystem= new Filesystem();
            if($filesystem->exists($npath)) {
                if ($filesystem->isWritable($npath)) {
                    $newpath = $npath . $idSolicitudNew;
                    File::makeDirectory($newpath, 0777, true, true);


                    if (!empty($files)) {
                        $indexs=array_keys($files);
                        for ($i = 0; $i < count($indexs); $i++) {
                            $index = $indexs[$i];
                            $req = Requisito::findOrFail($index);
                            $name = $this->replaceAccents($req->nombreRequisito). '.' . $files[$index]->getClientOriginalExtension();
                            $type = $files[$index]->getClientMimeType();
                            $files[$index]->move($newpath, $name);

                            $doc = new Documento();
                            $doc->urlDoc = $newpath.'\\'.$name;
                            $doc->tipoDoc = $type;
                            $doc->usuarioCreacion = $idUsuarioCrea;
                            $doc->save();

                            $idDocumento= $doc::all()->last()->idDocumento;

                            $solDoc = new SolicitudDocumento();
                            $solDoc->idSolicitud=$idSolicitudNew;
                            $solDoc->idDocumento= $idDocumento;
                            $solDoc->idRequisito= $index;
                            $solDoc->usuarioCreacion=$idUsuarioCrea;
                            $solDoc->save();

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
            return 0;
        }
        catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            return 0;
        }
    }/* /FIN DE LA FUNCION DE GUARDAR LOS ARCHIVOS*/

    public function editarDocumentos($idSolicitudNew,$files,$idUsuarioCrea,$idEstado){
        /* FUNCION PARA GUARDAR LOS ARCHIVOS */
        //DB::connection('sqlsrv')->beginTransaction();

        try {

            $npath=$this->pathfiles.'post\\';

            $filesystem= new Filesystem();
            if($filesystem->exists($npath)) {
                if ($filesystem->isWritable($npath)) {
                    $newpath = $npath . $idSolicitudNew;
                    File::makeDirectory($newpath, 0777, true, true);


                    if (!empty($files)) {
                        $indexs=array_keys($files);
                        for ($i = 0; $i < count($indexs); $i++) {
                            $index = $indexs[$i];
                            $req = Requisito::findOrFail($index);
                            $name = $this->replaceAccents($req->nombreRequisito). '.' . $files[$index]->getClientOriginalExtension();
                            $type = $files[$index]->getClientMimeType();
                            $files[$index]->move($newpath, $name);

                            $documento=SolicitudDocumento::getDocumento($idSolicitudNew,$index);
                            if(!empty($documento)){
                                $documento->urlDoc= $newpath.'\\'.$name;
                                $documento->tipoDoc = $type;
                                $documento->usuarioModificacion = $idUsuarioCrea;
                                $documento->save();
                            }else{
                                $doc = new Documento();
                                $doc->urlDoc = $newpath.'\\'.$name;
                                $doc->tipoDoc = $type;
                                $doc->usuarioCreacion = $idUsuarioCrea;
                                $doc->save();

                                $idDocumento= $doc::all()->last()->idDocumento;

                                $solDoc = new SolicitudDocumento();
                                $solDoc->idSolicitud=$idSolicitudNew;
                                $solDoc->idDocumento= $idDocumento;
                                $solDoc->idRequisito= $index;
                                $solDoc->usuarioCreacion=$idUsuarioCrea;
                                $solDoc->save();
                            }

                            $solisegui = new SolicitudSeguimiento();
                            $solisegui->idSolicitud= $idSolicitudNew;
                            $solisegui->idEstado=$idEstado;
                            $solisegui->seguimiento='El documento '.$name.' fue modificado por usuario '.$idUsuarioCrea;
                            $solisegui->usuarioCreacion=$idUsuarioCrea;
                            $solisegui->save();

                        }

                      //  DB::connection('sqlsrv')->commit();
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
           // DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            return 0;
        }
        catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            return 0;
        }
    }/* /FIN DE LA FUNCION DE GUARDAR LOS ARCHIVOS*/


    public function docByRequisito(Request $request){

        $documento=SolicitudDocumento::getDocumento(Crypt::decrypt($request->idSolicitud),Crypt::decrypt($request->idRequisito));


        if($documento!=null){
            if($documento->tipoDoc==='application/pdf'){
                //parte nueva
                //$archivo->tipoArchivo='application/pdf';
                if (File::isFile($documento->urlDoc))
                {
                    $file = File::get($documento->urlDoc);
                    $response = Response::make($file, 200);
                    // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
                    $response->header('Content-Type', 'application/pdf');
                    /*
                    $response->header([
                      'Content-Type'=> 'application/pdf',
                      'Content-Disposition' => 'inline; filename="Arte#"'
                      ]);*/
                    return $response;
                }
            }
            // Or to download
            else{
                if (File::isFile($documento->urlDoc))
                {

                    return Response::download($documento->urlDoc);
                }
            }
        }

    }

    public function revisionSolicitud($idSolicitud)
    {
        //dd($request->all()
        try{
            $solicitud=SolicitudPost::findOrFail(Crypt::decrypt($idSolicitud));
            $data = ['title' => 'Revision de Solicitud: ' .$solicitud->numeroSolicitud,
                'subtitle' => ''];
            $data['solicitud']=$solicitud;
            $datosDoc=$solicitud->documentos()->pluck('idRequisito')->toArray();
            if(count($datosDoc)>0){
                $data['documentoGuardados']=$datosDoc;
            }else{
                $data['documentoGuardados']=[];
            }
            $data['estados']=EstadoSolicitud::whereIN('idEstado',[3,4,5])->get()->toArray();
        }
        catch(\Exception $e){
            throw $e;
        }

        //dd($solicitud->solicitante);
        //dd($data['estados']);
        return view('postRegistro.revisarSolicitud', $data);
    }

    public function storeRevisionSol(Request $request){
        $usuarioCreacion= Auth::User()->idUsuario . '@' . $request->ip();
        try {
             DB::connection('sqlsrv')->beginTransaction();
            $solicitud = SolicitudPost::findOrFail(Crypt::decrypt($request->idSolicitud));
            $requisito =$request->requisito;
            $items =$request->items;
            $txtObservacion = $request->txtObservacion;
            $obserGeneral="";

            for($a=0;$a<count($txtObservacion);$a++){
                if(strlen($txtObservacion[$a])>0){
                    $ite=Requisito::find($items[$a]);
                    $obserGeneral .= "<b>-".$ite->nombreRequisito."</b>: ".$txtObservacion[$a].'.<br>';
                }
            }
            $obserGeneral .= $request->observaciones;

            $dictamen = new Dictamen();
            $dictamen->idSolicitud=$solicitud->idSolicitud;
            $dictamen->idEstado=$request->estado;
            $dictamen->observaciones=$obserGeneral;
            $dictamen->usuarioCreacion =Auth::User()->idUsuario;
            $dictamen->save();
            $idDictamen=$dictamen::all()->last()->idDictamen;

            for($a=0;$a<count($requisito);$a++){
                $detalle=new DictamenDetalle();
                $detalle->idDictamen=$idDictamen;
                $detalle->idRequisito=$items[$a];
                $detalle->opcion=$requisito[$a];
                $detalle->observacion = $txtObservacion[$a];
                $detalle->usuarioCreacion=$usuarioCreacion;
                $detalle->save();
            }
            if($solicitud->idTramite==7){
                if($request->has('fragancianew')){
                        $solicitud->fragancia()->delete();
                        foreach ($request->fragancianew as $key => $fragancia) {
                            $fra = new SolFragancia();
                            $fra->fragancia = $fragancia;
                            $fra->usuarioCreacion=$usuarioCreacion;
                            $fra->idSolicitud=$solicitud->idSolicitud;
                            $fra->save();
                        }
               }else{
                     DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Ingresar una o más fragancias!'],200);
               }
            }
            elseif($solicitud->idTramite==8){
                 if($request->has('tononew')){
                    $solicitud->tono()->delete();
                    foreach ($request->tononew as $key => $tono){
                        $ton = new SolTono();
                        $ton->idSolicitud=$solicitud->idSolicitud;
                        $ton->tono = $tono;
                        $ton->usuarioCreacion=$usuarioCreacion;
                        $ton->save();
                    }
                }else{
                      DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Ingresar uno o más tonos!'],200);
                }
            }elseif($solicitud->idTramite==22){
                if($request->has('fechaReconocimiento')){
                    if(!empty($solicitud->fechareconocimiento)){
                            SolFechaReconocimiento::where('idSolicitud',$solicitud->idSolicitud)->update(['fecha'=>$request->fechaReconocimiento,'usuarioModificacion'=>$usuarioCreacion]);
                    }else{
                         SolFechaReconocimiento::create(['idSolicitud'=>$solicitud->idSolicitud,'fecha'=>$request->fechaReconocimiento,'usuarioCreacion'=>$usuarioCreacion]);
                    }
                }else{
                      DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Se debe de ingresar una fecha de vigencia!'],200);
                }
            }else if($solicitud->idTramite==11 || $solicitud->idTramite==17){
                if($request->has('idDenominacion')){
                    $solicitud->formula()->delete();
                    $iddeno=$request->idDenominacion; $ncas=$request->ncas; $nombreDenominacion=$request->nombreDenominacion; $porcentaje=$request->porcentaje;
                    foreach($iddeno as $key => $fom){
                        $formu = new SolFormula();
                        $formu->idSolicitud= $solicitud->idSolicitud;
                        $formu->idDenominacion=$fom;
                        $formu->nombreDenominacion=$nombreDenominacion[$key];
                        $formu->porcentaje=$porcentaje[$key];
                        $formu->ncas=$ncas[$key];
                        $formu->usuarioCreacion=$usuarioCreacion;
                        $formu->save();
                    }
                }else{
                      DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Se debe de ingresar una o más sustancias!'],200);
                }
            }else if($solicitud->idTramite==14 || $solicitud->idTramite==23){
                if($request->has('nombreNuevo')){
                    SolNombreComercial::where('idSolicitud',$solicitud->idSolicitud)->update(['nombreNuevo'=>$request->nombreNuevo,'usuarioModificacion'=>$usuarioCreacion]);
                }else{
                    return response()->json(['status'=>404,'message'=>'¡Debe de ingresar un nombre comercial!'],200);
                }
            }else if($solicitud->idTramite==16 || $solicitud->idTramite==18){
                if($request->has('presentaciones')){
                    $solicitud->presentaciones()->delete();
                    foreach ($request->presentaciones as $presentacion) {
                                $present = json_decode($presentacion);
                                $solPresentacion = new SolPresentacion();
                                if(isset($present->idSolicitud)){
                                    $solPresentacion::create(json_decode($presentacion,true));
                                }
                                else {
                                    $solPresentacion->idSolicitud = $solicitud->idSolicitud;
                                    $solPresentacion->idEnvasePrimario = $present->emppri;
                                    $solPresentacion->idMaterialPrimario = $present->matpri;
                                    $solPresentacion->contenidoPrimario = $present->contpri;
                                    $solPresentacion->idUnidad = $present->unidadmedidapri;
                                    if ($request->unidadmedidapri == 11) {
                                        $solPresentacion->peso = $present->idMedida;
                                        $solPresentacion->idMedida = $present->medida;
                                    }

                                    if ($present->checkempsec == 1) {
                                        $solPresentacion->idEnvaseSecundario = $present->empsec;
                                        $solPresentacion->idMaterialSecundario = $present->matsec;
                                        $solPresentacion->contenidoSecundario = $present->contsec;
                                    }

                                    $solPresentacion->nombrePresentacion = $present->nombrePres;
                                    $solPresentacion->textoPresentacion = $present->textPres;
                                    $solPresentacion->usuarioCreacion = $usuarioCreacion;
                                    $solPresentacion->save();
                                }
                    }
                    if($request->has('deleIdPresentacion')){
                        $nombre = $request->deleteTexto;
                        foreach($request->deleIdPresentacion as $key => $idpre){
                            $deletepre = new PresentacionesDelete();
                            $deletepre->idSolicitud = $idSolicitud;
                            $deletepre->idPresentacion = $idpre;
                            $deletepre->nombrePresentacion = $nombre[$key];
                            $deletepre->usuarioCreacion = $usuarioCreacion;
                            $deletepre->save();
                        }

                    }
                }else{
                     DB::connection('sqlsrv')->rollback();
                     return response()->json(['status' => 404, 'message' => '¡Ingresar uno o más presentaciones!'],200);
                }
            }
            $archivos=$request->file('file-es');

            if(!empty($archivos)){
                $saveDocs=SolicitudesPostController::editarDocumentos($solicitud->idSolicitud,$request->file('file-es'),$usuarioCreacion,$request->estado);
                if($saveDocs==0){
                    DB::connection('sqlsrv')->rollback();
                    return response()->json(['status' => 404, 'message' => 'Error en el sistema: No se han podido guardar los documentos adjuntos, por favor vuelva intentarlo!'],200);
               }

            }
            $solicitud->idEstado = $request->estado;
            $solicitud->usuarioModificacion = $usuarioCreacion;
            $solicitud->save();
            if($request->estado==3){
                $estado2='FAVORABLE';
            }else if($request->estado==4){
                $estado2='OBSERVADO';
            }else{
                $estado2='DESFAVORABLE';
            }

            if($request->estado==4 || $request->estado==5){
                    $persona=SolPre::getPersonaN($solicitud->nitSolicitante);
                    $correo=$persona[0]->emailsContacto;
                    $data['solicitud'] =$solicitud;
                    $data['observacion'] = $obserGeneral;
                   if (!empty($correo) || $correo != null || $correo != ''){
                            Mail::send('postRegistro.email.notificarSolPost', $data, function ($msj) use ($correo) {
                                $msj->subject('TRÁMITE DE POST REGISTRO COSMÉTICOS E HIGIÉNICOS');
                                $msj->to($correo);
                                $msj->bcc('cosmeticos.higienicos@medicamentos.gob.sv');
                            });
                    }
            }
            /*if($request->estado==3 || $request->estado==5){
                //GUARDAMOS EL ÚLTIMO ESTADO QUE TENDRA LA SOLICITUD PARA VALIDAR EN CERTIFICACIÓN DE SOLICITUDES
                SolPostEstadosSesion::create(['idSolicitud'=>$solicitud->idSolicitud,'idEstado'=>$request->estado,'idDictamen'=>$idDictamen,'usuarioCreacion'=>$usuarioCreacion]);
            }*/


            SolicitudSeguimiento::create(['idSolicitud'=>$solicitud->idSolicitud,'idEstado'=>$request->estado,'seguimiento'=>'Dictamen creado con estado '.$estado2,'usuarioCreacion'=>$usuarioCreacion]);
            DB::connection('sqlsrv')->commit();

        }catch (\Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().$e->getLine().$e->getFile()]);
            response()->json(['status' => 404, 'message' => 'Problemas al enviar los datos, contactar con informática'],200);
            //throw  $e;
        }
        return response()->json(['status' => 200, 'message' => 'Revisión ingresada','idDictamen'=>Crypt::encrypt($idDictamen)],200);


    }

    public function solicitudFavorable(Request $request){
        //dd($request->all());
        $idSol=Crypt::decrypt($request->idSolicitud);
        $idSes=Crypt::decrypt($request->idSesion);

        try{
            $solicitud=SolicitudPost::findOrFail($idSol);
            if($solicitud->idEstado==9) $title='Solicitud '.$solicitud->numeroSolicitud.' Certificada';
            else $title='Solicitud a Certificar: '.$solicitud->numeroSolicitud;
            $data = ['title' => $title,
                'subtitle' => ''];
            $data['solicitud']=$solicitud;
            $datosDoc=$solicitud->documentos()->pluck('idRequisito')->toArray();
            if(count($datosDoc)>0){
                $data['documentoGuardados']=$datosDoc;
            }else{
                $data['documentoGuardados']=[];
            }
            $data['idSesion']=$idSes;
        }
        catch(\Exception $e){
            throw $e;
        }

        return view('postRegistro.solicitudfavorable', $data);
    }

    public function certificarSol(Request $request){

        $usuarioCreacion= Auth::User()->idUsuario . '@' . $request->ip();
        $producto=null;
        $titular=null;
        $profesional=null;
        $nombreTitular='';


        DB::connection('sqlsrv')->beginTransaction();

        try {

            $solicitud = SolicitudPost::findOrFail(Crypt::decrypt($request->idSolicitud));

            if($solicitud->tipoProducto=='COS'){
                $producto=Cosmetico::findOrFail($solicitud->noRegistro);
            }
            else if($solicitud->tipoProducto=='HIG'){
                $producto=Higienico::findOrFail($solicitud->noRegistro);
            }

            if($producto->tipoTitular==1 || $producto->tipoTitular==2) $titular=$producto->titular12;
            else $titular=$producto->titular3;


            //dd($titular);
            if(empty($titular) || $titular== null){
                Session::flash('msnError','Error en el sistema: El producto no posee titular!');
                Log::warning('Error en el sistema: El producto '.$solicitud->noRegistro.' no posee titular!');
                return response()->json(['status' => 404, 'message' => 'El producto '.$solicitud->noRegistro.' no posee titular!'],200);
            }
            else{
                if($producto->tipoTitular==3) $nombreTitular = $titular->NOMBRE_PROPIETARIO;
                else $nombreTitular = $titular->nombre;

            }
            //dd($titular);

            if(!empty($producto->profesional)) $profesional=$producto->profesional->profesional;

            if(empty($profesional) || is_null($profesional)){
                Session::flash('msnError','Error en el sistema: El producto no posee profesional!');
                Log::warning('Error en el sistema: El producto '.$solicitud->noRegistro.' no posee profesional!');
                return response()->json(['status' => 404, 'message' => 'El producto '.$solicitud->noRegistro.' no posee profesional!'],200);
            }

            $fabri = $producto::existeFabri($solicitud->noRegistro);
            if (count($fabri) > 0) {
                $fabricante='';
                //$fabricantes = $producto::getFabricantes($solicitud->noRegistro);
                //$fabricantes = FabricantesCosmeticos::fabricantes($fabri->pluck('idFabricante'));
                 $fabricantes = $producto::getFabricantes($solicitud->noRegistro);
                    //$fabricantes = FabricantesCosmeticos::fabricantes($fabri->pluck('idFabricante'));
                    if(empty($fabricantes)){
                        Session::flash('msnError','Error en el sistema: El producto no posee fabricante!');
                         return response()->json(['status' => 404, 'message' => 'El producto '.$solicitud->noRegistro.' no posee fabricante!'],200);
                    }else{
                            if(count($fabricantes)>1){
                                foreach($fabricantes  as $rr){
                                    $fabricante .= $rr->NOMBRE_COMERCIAL."(".$rr->pais."), ";
                                }
                            }else{
                                foreach($fabricantes  as $pp){
                                    $fabricante .= $pp->NOMBRE_COMERCIAL."(".$pp->pais.")";
                                }
                            }
                 }
            } else {
                Session::flash('msnError','Error en el sistema: El producto no posee fabricante!');
                Log::warning('Error en el sistema: El producto '.$solicitud->noRegistro.' no posee fabricante!');
                return response()->json(['status' => 404, 'message' => 'El producto '.$solicitud->noRegistro.' no posee fabricantes!'],200);
            }

            //Renovación
            if($solicitud->idTramite==1 || $solicitud->idTramite==21){
                $newrenovacion=date('Y-m-d',strtotime('+5 years',strtotime($producto->renovacion)));
                $producto->renovacion= $newrenovacion;
                $producto->idUsuarioModificacion=$usuarioCreacion;
                $producto->save();

                DB::connection('sqlsrv')->insert('EXEC POST.certificarSolRenovacion ?,?,?,?,?,?',[$solicitud->idSolicitud,
                          $profesional->NOMBRES.' '.$profesional->APELLIDOS,$nombreTitular,
                          $fabricante,$usuarioCreacion,$this->convertDateToText($newrenovacion)]);
                SolicitudSeguimiento::create(['idSolicitud'=>$solicitud->idSolicitud,'idEstado'=>9,'seguimiento'=>'Solicitud certificada','usuarioCreacion'=>$usuarioCreacion]);
            }else if($solicitud->idTramite==22){
                $newrenovacion=$solicitud->fechareconocimiento->fecha;
                $producto->renovacion= $newrenovacion;
                $producto->idUsuarioModificacion=$usuarioCreacion;
                $producto->save();

                DB::connection('sqlsrv')->insert('EXEC POST.certificarSolRenovacion ?,?,?,?,?,?',[$solicitud->idSolicitud,
                          $profesional->NOMBRES.' '.$profesional->APELLIDOS,$nombreTitular,
                          $fabricante,$usuarioCreacion,$this->convertDateToText($newrenovacion)]);
                SolicitudSeguimiento::create(['idSolicitud'=>$solicitud->idSolicitud,'idEstado'=>9,'seguimiento'=>'Solicitud certificada','usuarioCreacion'=>$usuarioCreacion]);

            }

            $solicitud->idEstado = 9;
            $solicitud->usuarioModificacion = $usuarioCreacion;
            $solicitud->save();

            DB::connection('sqlsrv')->commit();
        }
        catch (\Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
            return response()->json(['status' => 404, 'message' => 'Error en el sistema!'],200);
        }
        return response()->json(['status' => 200, 'message' => 'SOLICITUD CERTIFICADA','idSolicitud'=>Crypt::encrypt($solicitud->idSolicitud)],200);
        //dd($producto);
        /*Session::flash('msnExito','La solicitud '.$solicitud->idSolicitud.' con trámite de '.$solicitud->tramite->nombreTramite.' fue certificada existosamente!');
        if($solicitud->tramite->sesion==1){
            return redirect()->route('sols.certificar.sesionespost',['idSesion'=>Crypt::encrypt($request->idSesion)]);
        }
        else {
            return back();
        }*/
    }


    public function pdfAllCertificaciones(){

        try {
            $idSolicitudes=vwSolicitudes::getIdsSolCertificadas();
            $solicitudes = SolicitudPost::whereIn('idSolicitud',$idSolicitudes)->get();
            foreach ($solicitudes as $solicitud){
                $solicitud->fechaModificacionText = $this->convertDateToText($solicitud->fechaModificacion);
            }
            $pdf = PDF::loadView('postRegistro.pdf.certificaciones', ['solicitudes' => $solicitudes]);
        }
        catch (\Exception $e){
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $pdf->stream('certificaciones.pdf');
    }

    public function getRequisitosByTramite(Request $request){
        try{
            $tramite=Tramite::findOrFail($request->idTra);
            $requisitos= $tramite->requisitos;

            if(!empty($requisitos) && view()->exists('postRegistro.documentos')){
                return new JsonResponse([
                    'data'=>(String) view('postRegistro.documentos',['requisitos'=>$requisitos])
                ],200);
            }
            else{
                return new JsonResponse([
                    'message'=>'No se han podido cargar los requisitos'
                ],404);
            }
        }
        catch(\Exception $e){
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }

    public function certificarSolCambioEmpaque($solicitud,$user){
        $result=false;
        $filesystem= new Filesystem();
        $idItem=null;

        DB::connection('sqlsrv')->beginTransaction();
        try {
            //destino de expediente con el numero de registro
            $pathdest = Storage::disk('coshigexpedientes')->getDriver()->getAdapter()->getPathPrefix() . $solicitud->noRegistro;
            // documento de empaque nuevo de la solicitud post
            $documento = SolicitudDocumento::getDocumento($solicitud->idSolicitud, 2);
            if (empty($documento)) return $result;

            if ($solicitud->tipoProducto === 'COS') $idItem = 5;
            else if ($solicitud->tipoProducto === 'HIG') $idItem = 9;

            $item = Item::findOrFail($idItem);

            if ($filesystem->exists($pathdest) && $filesystem->isDirectory($pathdest)) {
                    $archivo = ProductoExpediente::where('productoId', $solicitud->noRegistro)->where( 'itemId', $item->idItem)->first()->archivoExpediente;
                    if (!empty($archivo)) {
                        $filesystem->delete($archivo->urlArchivo);
                        $source = $pathdest .'\\'. $item->nombreItem . '.pdf';
                        File::copy($documento->urlDoc, $source);
                        $archivo->update(['urlArchivo' => $source, 'actualizado' => 1, 'usuarioModificacion' => $user]);
                        $result = true;
                    }
            }
            else {
                    //dd($pathdest);
                    //SI NO EXISTE LA CARPETA DEL PRODUCTO SE CREA
                    File::makeDirectory($pathdest, 0777, true, true);
                    //guardamos el source del doc
                    $source = $pathdest .'\\'. $item->nombreItem . '.pdf';
                    //copiamos el nuevo documento de empaque a la carpeta del producto
                    File::copy($documento->urlDoc, $source);
                    // creamos el archivo expediente donde se guarda la url del documento
                    $archivo = ArchivoExpediente::create(['urlArchivo' => $source, 'tipoArchivo' => $documento->tipoDoc, 'usuarioCreacion' => $user]);
                    // enlazamos este archivo al producto para que pertenezca al expediente del mismo
                    ProductoExpediente::create(['productoId' => $solicitud->noRegistro, 'archivoExpId' => $archivo->idArchivoExp, 'itemId' => $item->idItem, 'usuarioCreacion' => $user]);
                    $result = true;
                    //dd($result);
            }


            DB::connection('sqlsrv')->commit();
        }
        catch(\Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }

    public function certificarAmpliacionFrag($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->fragancia) || !is_null($solicitud->fragancia->fragancia)){
                $producto->fragancias()->create(['fragancia'=>$solicitud->fragancia->fragancia,'estado'=>'A','idUsuarioCrea'=>$user]);
                DB::connection('sqlsrv')->commit();
                $result=true;
            }
            else{
                $result=false;
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }

    public function certificarAmpliacionTono($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->tono) || !is_null($solicitud->tono->tono)){
                $producto->tonos()->create(['tono'=>$solicitud->tono->tono,'estado'=>'A','idUsuarioCrea'=>$user]);
                DB::connection('sqlsrv')->commit();
                $result=true;
            }
            else{
                $result=false;
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }

    public function franganciaNewView(){
        if(view()->exists('postRegistro.tramites.fragancianew3')){
            $view= view('postRegistro.tramites.fragancianew3');
            return response()->json(['status' => 200, 'data' => (String)$view],200);
        }
        else{
            return response()->json(['status' => 404, 'message' => "No se han encontrado la vista de fragancia!"],404);
        }
    }

    public function tonoNewView(){
        if(view()->exists('postRegistro.tramites.tononew4')){
            $view= view('postRegistro.tramites.tononew4');
            return response()->json(['status' => 200, 'data' => (String)$view],200);
        }
        else{
            return response()->json(['status' => 404, 'message' => "No se han encontrado la vista de fragancia!"],404);
        }
    }
    public function fechareconocimientoNewView(){
        if(view()->exists('postRegistro.tramites.fechanew22')){
            $view= view('postRegistro.tramites.fechanew22');
            return response()->json(['status' => 200, 'data' => (String)$view],200);
        }
        else{
            return response()->json(['status' => 404, 'message' => "No se han encontrado la vista de fecha reconocimiento!"],404);
        }
    }
    public function cambioPresentacionView(Request $request){
        $idproducto=$request->idproducto;
        $tipo =$request->tipo;
        if($tipo=='COS'){
            $producto = Cosmetico::find($idproducto);
        }else{
            $producto = Higienico::find($idproducto);
        }
        $data['presentaciones']=$producto->presentaciones;
        if(view()->exists('postRegistro.tramites.presentaciones16-18')){
            $view= view('postRegistro.tramites.presentaciones16-18',$data);
            return response()->json(['status' => 200, 'data' => (String)$view],200);
        }
        else{
            return response()->json(['status' => 404, 'message' => "No se han encontrado la vista de fecha reconocimiento!"],404);
        }
    }
    public function cambioFormulacionNewView(Request $request){
        $idproducto=$request->idproducto;
        $tipo =$request->tipo;
        if($tipo=='COS'){
            $producto = Cosmetico::find($idproducto);
        }else{
            $producto = Higienico::find($idproducto);
        }
        if(!empty($producto->formula)){
            $data['formula'] = $producto->formula;
        }else{
            $data['formula'] = [];
        }
        if(view()->exists('postRegistro.tramites.formula11-17')){
            $view= view('postRegistro.tramites.formula11-17',$data);
            return response()->json(['status' => 200, 'data' => (String)$view],200);
        }
        else{
            return response()->json(['status' => 404, 'message' => "No se han encontrado la vista de formulación!"],404);
        }
    }
     public function cambioNombreComercialNewView(){
        if(view()->exists('postRegistro.tramites.nombreComercial14-23')){
            $view= view('postRegistro.tramites.nombreComercial14-23');
            return response()->json(['status' => 200, 'data' => (String)$view],200);
        }
        else{
            return response()->json(['status' => 404, 'message' => "No se han encontrado la vista de cambio de nombre!"],404);
        }
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
