<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Http\Request;
use Redirect;
use Yajra\Datatables\Datatables;
use App\Models\Solicitud;
use App\Models\EstadoSolicitud;
use App\Models\TiposTramites;
use App\Models\Cosmetico;
use App\Models\Envase;
use App\Models\Material;
use App\Models\SolicitudesDetalle;
use App\Models\SolicitudesTonos;
use App\Models\SolicitudesFragancias;
use App\Models\DetalleCosmetico;
use App\Models\Fabricantes;
use App\Models\Importadores;
use App\Models\ClasificacionCos;
use App\Models\ClasificacionHig;
use File;
use Filesystem;
use App\Models\SolicitudesPresentaciones;
use App\Models\SolicitudesDocumentos;
use App\Models\DetalleDocumentos;
use App\Models\DetalleHigienico;
use App\Models\Distribuidores;
use App\Models\PersonaNatural;
use App\Models\Dictamen;
use App\Models\FormulaCosmetico;
use App\Models\FormulaHigienico;
use App\Models\Area;
use App\Models\Marca;
use App\Models\SolicitudFabricantes;
use App\Models\VwPropietario;
use App\Models\Propietario;
use App\Models\Resolucion;
use App\Models\VwFabricanteExtranjero;
use App\Models\SolicitudesPre\SeguimientoSolPre;
use DB;
use Response;
use Crypt;
use Carbon\Carbon;
use Validator;
use Illuminate\Database\Eloquent\Collection;
use App\UserOptions;



class SolicitudController extends Controller
{


	public function nuevaSolicitud(){
    	$data=['title'=>'Nueva Solicitud',
    			'subtitle'=>''];
    	$tramites=Solicitud::getTramites();
      $areas=Area::all()->where('estado','A');
    	$marcas=Marca::where('estado','A')->orderBy('nombreMarca','ASC')->get();
    	$data['tramites']=$tramites;
    	$data['areas']=$areas;
    	$data['marcas']=$marcas;

    	return view ('solicitudes.index',$data);
    }

  public function editarSolicitud(Request $rq)
  {
    // usar las mismas vistas para editar la solicitud
    //return view ('solicitudes.index',$data);
  }

  public function getClasificacionesProductos(Request $request){
      //dd($request);
      if($request->tramite==2||$request->tramite==3){
           return $items=ClasificacionCos::getClasificacionCos();
      } else {
            return $items=ClasificacionHig::getClasificacionHig();
      }

    }
   public function getClasHig(){
    return $class=ClasificacionHig::getClasificacionHig();
   }
    public function getPaises(){

    return $pais=Solicitud::getPaises();
   }

    public function getMunicipios(Request $request){

      return Solicitud::getMunicipios($request->idDep);
    }
    public function getDepartamentos(){
          return Solicitud::getDepartamentos();
        }


    public function getTratamientos(){
      return Solicitud::getTratamientos();
    }




  public function buscarProfesionales(Request $request){                        //búsqueda de profesionales selectize
    $query = e($request->q);

    if(!$query && $query == '') return response()->json(array(), 400);

    $data=Solicitud::getProfesionales($query);

    return response()->json(array(
      'data'=>$data
    ));

   }

   public function buscarProfesionalesPorIdProf(Request $request){                        //búsqueda de profesionales selectize
    $query = e($request->q);

    if(!$query && $query == '') return response()->json(array(), 400);

    //$data=Solicitud::getProfesionales($query);
    $data= DB::connection('mysql')->table('cssp.cssp_profesionales as p')
         ->Join('cssp.siic_profesionales_poderes as pp','p.ID_PROFESIONAL','pp.ID_PROFESIONAL')
           ->select('p.ID_PROFESIONAL','pp.ID_PODER',DB::raw('CONCAT (p.NOMBRES," ",p.APELLIDOS) as NOMBRE_PROFESIONAL'))
           ->where('pp.ESTADO','A')
          ->where(function ($q) use($query) {
                $q->orWhere('p.ID_PROFESIONAL','like','%'.$query.'%')
                      ->orWhere(DB::raw('CONCAT (p.NOMBRES," ",p.APELLIDOS)'),'like','%'.$query.'%');
            })
         ->take(10)->get();

    return response()->json(array(
      'data'=>$data
    ));

   }

   public function buscarDistribuidores(Request $request){                       //búsqueda distribuidores selectize
    $query = e($request->q);

    if(!$query && $query == '') return response()->json(array(), 400);

    $data=Solicitud::getDistribuidores($query);

    return response()->json(array(
      'data'=>$data
    ));

   }


   public function buscarDistribuidor(Request $request){

      return Solicitud::getDistribuidorByPoder($request->poder);

   }

   public function buscarProfesional(Request $request){
    return $profesional=Solicitud::getProfesional($request->id);
   }


    public function buscarPersonas(Request $request){
      $query = e($request->q);//nombre para buscar

      if(!$query && $query == '') return response()->json(array(), 400);

      $data=Solicitud::getPersonasNaturales($query); // Personas naturales registrados

      return response()->json(array(
      'data'=>$data
       ));
    }

    public function buscarFormulas(Request $request){
   //   dd($request);
      $query = strtoupper(e($request->q));//nombre para buscar
    //  dd(strtoupper($query));
      if(!$query && $query == '') return response()->json(array(), 400);

      if($request->tipotramite==2||$request->tipotramite==3)
        $data=Solicitud::getFormulasCosmeticos($query); // busqueda de formulas INCI para cos e higienicos depende del tramite

     else
        $data=Solicitud::getFormulasHigienicos($query);

      return response()->json(array(
      'data'=>$data
       ));
    }

    public function buscarFormulasHig(Request $request){
       $query = e($request->q);//nombre para buscar


      if(!$query && $query == '') return response()->json(array(), 400);

        $data=Solicitud::getFormulasHigienicos(strtoupper($query)); // busqueda de formulas INCI para cos e higienicos depende del tramite

      return response()->json(array(
      'data'=>$data
       ));
    }

    public function buscarFormulaPorId(Request $request){
      return $formula=Solicitud::buscarSustanciaPorId($request->id);

    }

    public function buscarFormulaHigPorId(Request $request){
      return $formula=Solicitud::buscarSustanciaHigPorId($request->id);

    }

    public function getPersona(Request $request){
    //  dd($request->id);
      return $persona=Solicitud::getPersonaN($request->id);
    }



    public function getItems(Request $request){
      return $items=Solicitud::getItems($request->id);
    }

    public function getItemsEditar(Request $request){
      $data['items']=Solicitud::getItems($request->id);
      $data['docs']=SolicitudesDetalle::getDocumentosSol($request->idSol);
      return $data;
    }


   public function getEnvases(){
     return $envases=Envase::getEnvasesCosmeticos();
   }

   public function getMateriales(){
     return $material=Material::getMateriales();
   }

   public function getUnidades(){
    return $unidades=Solicitud::getUnidades();
   }

    public function guardarPersona(Request $request){

      try{
          $persona= new PersonaNatural();
          $persona->nitNatural=$request->nit;
          $persona->numeroDocumento=$request->numeroDoc;
          $persona->idTipoDocumento=$request->tipoDoc;
          $persona->nombres=$request->nombres;
          $persona->apellidos=$request->apellidos;
          $persona->fechaNacimiento=$request->fechaNac;
          $persona->idMunicipio=$request->municipio;
          $persona->direccion=$request->direccion;
          $persona->idTipoTratamiento=$request->tratamiento;
          $persona->sexo=$request->sexo;
          $persona->emailsContacto=$request->email;
          $telefonos = array();
          $telefonos[0]=$request->tel;
          $persona->telefonosContacto=json_encode($telefonos);
          $persona->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
          $persona->save();
          return response()->json(['status' => 200, 'message' => "OK"],200);
      } catch (Exception $e) {
           throw $e;
          return response()->json(['status' => 500, 'message' => "Error, No se guardo la Persona Natural"],200);
      }


   }

  public function validarManda(Request $rq){
      $verificacion="";
      $response = ['status' => 404, 'message' => "Debe ingresar un número de mandamiento"];
      try
      {
        if ($rq->has('mandamiento'))
        {
          $mandamientoUtilizados=Solicitud::verificarSol($rq->mandamiento);



          $verificacion = DB::connection('mysql')->table('cssp.cssp_mandamientos as m')
                ->join('cssp.cssp_mandamientos_detalle as md','md.id_mandamiento','=','m.id_mandamiento')
                ->join('cssp.cssp_mandamientos_recibos as mr','mr.id_mandamiento', '=','m.id_mandamiento')
                ->join('cssp.cssp_tipos_pagos_col as col','col.id_tipo_pago','=','md.id_tipo_pago')
                //->whereNotIn('m.id_mandamiento',$mandamientoUtilizados)
                //->whereIn('col.id_tipo_pago',[3649,3654,3656,3679,3684,3685])
                ->where('m.id_mandamiento',$rq->mandamiento)
                ->select('md.COMENTARIOS','mr.ID_RECIBO','md.correlativo','m.id_mandamiento', 'm.id_cliente', 'm.a_nombre', 'm.total', 'md.valor as valorDet', 'col.nombre_tipo_pago', 'mr.fecha', 'mr.total_cobrado')
                ->get();
          if(count($verificacion) > 0)
            $response = ['status' => 200, 'data' => $verificacion];
          else
            $response = ['status' => 404, 'message' => "El mandaminento no es válido."];
        }

        return response()->json($response);

      }
      catch (Exception $e)
      {
        return response()->json(['status' => 404, 'message' => "No fue posible validar el mandamiento, favor contacte a DNM informática"],200);
      }


  }

   public function guardarsolNuevoCos(Request $request){

        $messages = [
          'nombreComercial.required' => 'El campo :attribute es requerido.',
          'id_propietario.required' => 'Debe seleccionar un propietario.',
          'ID_PROFESIONAL.required' => 'Debe seleccionar un profesional responsable',
          'idPersona.required'=>'Debe seleccionar una persona para contacto',
          'mandamiento.required'=>'Debe ingresar un mandamiento de pago válido',
          ];

        $rules=[
              'nombreComercial'   =>  'required',
              'id_propietario'   =>  'required',
              'ID_PROFESIONAL'=>'required',
              'idPersona'=>'required',
              'mandamiento'=>'required'
            ];

        if($request->coempaque==1){
          $messages+=['nomCoempaque.required' => 'El campo Detalle el Nombre Comercial del otro producto que compone el coempaque es requerido.',];
          $rules+=['nomCoempaque'=>'required'];
        }

        if($request->idTramite==3||$request->idTramite==5){
            $messages+=[ 'paisOrigen.required' => 'El campo :attribute es requerido.',
                         'numRegistro.required' => 'El campo :attribute es requerido.',
                         'fechaVen.required' => 'El campo :attribute es requerido.',];
            $rules+=['paisOrigen'=>'required',
                      'numRegistro'=>'required',
                      'fechaVen'=>'required'];

        }

        if($request->idTramite==2||$request->idTramite==3){

              $messages+=[ 'class.required' => 'Debe seleccionar una clasificación.',
                          'forma.required' => 'Debe seleccionar una forma cosmética.',];

              $rules+=[ 'class'   =>  'required',
                        'forma'   =>  'required',];

        } else {
              $messages+=[ 'uso.required' => 'Debe ingresar el uso del Higienico.',
                           'classH.required' => 'Debe seleccionar una clasificación.',];

              $rules+=[ 'uso'   =>  'required',
                        'classH'   =>  'required',];
        }

          $v = Validator::make($request->all(),$rules, $messages);

          $v->setAttributeNames([
          'nombreComercial'   =>  'Nombre Comercial',
          'paisOrigen'=>'Pais de Origen',
          'fechaVen'=>'Fecha de Vencimiento'
          ]);

          if ($v->fails())
            {
              $msg = "<ul class='text-warning'>";
              foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
              }
              $msg .= "</ul>";
                return response()->json(['status' => 404,'message' => 'Debe completar:', 'data' => ['message'=>$msg]]);
            }


          $data=['title'=>'Ver Solicitud',
              'subtitle'=>''];
          $tramites=Solicitud::getTramites();
          $areas=Area::all()->where('estado','A');
          $marcas=Marca::all()->where('estado','A');
          $data['tramites']=$tramites;
          $data['areas']=$areas;
          $data['marcas']=$marcas;

         // DB::connection('sqlsrv')->beginTransaction();
          try{
            $solicitud= new Solicitud();                           //Guardo Solictud
            $solicitud->tipoSolicitud=$request->idTramite;
            $solicitud->idMandamiento=$request->mandamiento;
            $solicitud->nitSolicitante=$request->idPersona;
            $solicitud->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
            $solicitud->poseeCoempaque=$request->coempaque;
            $solicitud->descripcionCoempaque=$request->nomCoempaque;
            $solicitud->estado=1;
            $solicitud->save();
                   //echo $solicitud;
            $sol = Solicitud::all()->last();

            $detalle=new SolicitudesDetalle();                       //Guardo el detalle con el id de la solicitud ingresada.
            $detalle->idSolicitud=$sol->idSolicitud;
            $detalle->tipoTitular=$request->tipoT;
            $detalle->nombreComercial=$request->nombreComercial;
            $detalle->idMarca=$request->marca;
            $detalle->idTitular=$request->id_propietario;
            $detalle->idProfesional=$request->ID_PROFESIONAL;
            $detalle->idPoderProfesional=$request->ID_PODER;
            $detalle->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();

              if($request->idTramite=='3'||$request->idTramite=='5'){         //verifico si el tramite es Reconocimiento
                  $detalle->idPais=$request->paisOrigen;
                  $detalle->numeroRegistroExtr=$request->numRegistro;
                  $detalle->fechaVencimiento=$request->fechaVen;
              } else {
                $detalle->idPais=222;                                   // pais 2= El salvador
              }
            $detalle->save();                                         //Guardo datos del reconocimiento

           $numDetalle= SolicitudesDetalle::all()->last();
           //Guardo detalle de Cosmetico o higienico, busco detalle guardado

            if($request->idTramite==2||$request->idTramite==3){    // tramite nuevo registro o reconocimiento cosmetico guardo detalle cosmetico

              $detalleCos=new DetalleCosmetico();
              $detalleCos->idDetalle=$numDetalle->idDetalle;
              $detalleCos->idClasificacion=$request->class;
              $detalleCos->idFormaCosmetica=$request->forma;
              $detalleCos->idUsuarioCreacion=Auth::User()->idUsuario.'@'.$request->ip();
              $detalleCos->save();
              }
             if($request->idTramite==4||$request->idTramite==5){ //tramite nuevo registro o reconocimiento higienico guardo detalle cosmetico
              $detalleHig=new DetalleHigienico();
              $detalleHig->idDetalle=$numDetalle->idDetalle;
              $detalleHig->idClasificacion=$request->classH;
              $detalleHig->uso=$request->uso;
              $detalleHig->idUsuarioCreacion=Auth::User()->idUsuario.'@'.$request->ip();
              $detalleHig->save();
              }

             SeguimientoSolPre::create(['idSolicitud'=>$sol->idSolicitud,'idEstado'=>1,'seguimiento'=>'Solicitud creada por el ténico: '.Auth::User()->idUsuario,'usuarioCreacion'=>Auth::User()->idUsuario.'@'.$request->ip()]);

            //DB::connection('sqlsrv')->commit();
             return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => ['idSolicitud'=>$sol->idSolicitud]]);

        }  catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => ['error',$e]]);

        }

      }

    public function guardarSolicitudCosDetalle(Request $request)
    {
        //dd($request);
        DB::connection('sqlsrv')->beginTransaction();
        $solicitud = Solicitud::find($request->idSolicitud);
        // dd($solicitud);
        try {
            Fabricantes::where('idSolicitud',$solicitud->idSolicitud)->delete();
            Distribuidores::where('idSolicitud',$solicitud->idSolicitud)->delete();
            Importadores::where('idSolicitud',$solicitud->idSolicitud)->delete();
            FormulaCosmetico::where('idSolicitud',$solicitud->idSolicitud)->delete();
            FormulaHigienico::where('idSolicitud',$solicitud->idSolicitud)->delete();
            //SolicitudesTonos::where('idSolicitud',$solicitud->idSolicitud)->delete();
            //SolicitudesFragancias::where('idSolicitud',$solicitud->idSolicitud)->delete();
            if(!empty($request->ID_FABR)) {
                for ($i = 0; $i < count($request->ID_FABR); $i++) {            //Guarda un registro por cada fabricante agregado
                    $fabricante = new Fabricantes();
                    $fabricante->idSolicitud = $request->idSolicitud;
                    $fabricante->idFabricante = $request->ID_FABR[$i];
                    $fabricante->tipoFabricante = $request->origen;
                    $fabricante->idUsuarioCreacion = Auth::User()->idUsuario . '@' . $request->ip();
                    $fabricante->save();
                }
            }
            $solicitud->distribuidorTitular=$request->disTitu;

            if(!empty($request->PODER_DIS)) {
                for ($i = 0; $i < count($request->PODER_DIS); $i++) {            //Guarda un registro por cada DISTRIBUIDOR agregado
                    $distribuidor = new Distribuidores();
                    $distribuidor->idSolicitud = $request->idSolicitud;
                    $distribuidor->idPoderDistribuidor = $request->PODER_DIS[$i];
                    $distribuidor->idDistribuidor = $request->ID_DIS[$i];
                    $distribuidor->idUsuarioCreacion = Auth::User()->idUsuario . '@' . $request->ip();
                    $distribuidor->save();
                }
            }

            if(!empty($request->ID_IMP)) {
                for ($i = 0; $i < count($request->ID_IMP); $i++) {              //Guarda un registro por cada importador agregado
                    $importadores = new Importadores();
                    $importadores->idSolicitud = $request->idSolicitud;
                    $importadores->idImportador = $request->ID_IMP[$i];
                    $importadores->idUsuarioCreacion = Auth::User()->idUsuario . '@' . $request->ip();
                    $importadores->save();
                }
            }

            if ($solicitud->tipoSolicitud == 2 || $solicitud->tipoSolicitud == 3) {
                if(!empty($request->sustFinal)) {
                    for ($i = 0; $i < count($request->sustFinal); $i++) {              //Guarda un registro por cada sustancia agregada
                        $formulaCosmetico = new FormulaCosmetico();
                        $formulaCosmetico->idSolicitud = $request->idSolicitud;
                        $formulaCosmetico->idDenominacion = $request->sustFinal[$i];
                        $formulaCosmetico->porcentaje = (float)$request->porc[$i];
                        $formulaCosmetico->idUsuarioCreacion = Auth::User()->idUsuario . '@' . $request->ip();
                        $formulaCosmetico->save();
                    }
                }
            } else
            {
                if($request->sustFinal) {
                    for ($i = 0; $i < count($request->sustFinal); $i++) {              //Guarda un registro por cada sustancia agregada
                        $formulaHigienico = new FormulaHigienico();
                        $formulaHigienico->idSolicitud = $request->idSolicitud;
                        $formulaHigienico->idDenominacion = $request->sustFinal[$i];
                        $formulaHigienico->porcentaje = (float)$request->porc[$i];
                        $formulaHigienico->idUsuarioCreacion = Auth::User()->idUsuario . '@' . $request->ip();
                        $formulaHigienico->save();
                    }
                }
            }


            if ($request->tonos[0]!="") {                          //guardo Tonos Solicitud
                for ($i = 0; $i < count($request->tonos); $i++) {
                    $tono = new SolicitudesTonos();
                    $tono->idSolicitud = $request->idSolicitud;
                    $tono->tono = $request->tonos[$i];
                    $tono->idUsuarioCrea = Auth::User()->idUsuario.'@'.$request->ip();
                    $tono->save();
                }

            }
            //guardo Fragancias Solicitud
            if ($request->fragancias[0]!="") {

                for ($i = 0; $i < count($request->fragancias); $i++) {

                      $frag = new SolicitudesFragancias();
                      $frag->idSolicitud = $request->idSolicitud;
                      $frag->fragancia = $request->fragancias[$i];
                      $frag->idUsuarioCrea = Auth::User()->idUsuario.'@'.$request->ip();
                      $frag->save();


                }
            }

            //$newPath = 'Z:\COSHIG';                                         //unidad de red donde se guardaran                                                                           //Guardo documentos
            $newPath='Y:\COSHIG';                                         //unidad de red donde se guardaran
            $file = $request->file('files');                                   //obtengo los archivos
            //  dd($file[1]->getMimeType());
            $filesystem = new Filesystem();
            if ($filesystem->exists($newPath)) {                   //si hay archivos crear la ruta con el id de la solicitud
                if ($filesystem->isWritable($newPath)) {
                    $carpeta = $newPath . '\\' . $request->idSolicitud; //crea la nueva carpeta con el numero de solicitud
                    File::makeDirectory($carpeta, 0777, true, true);
                }
            }


            if (!empty($file)) {
                $indexs = array_keys($file);
                if(!empty($indexs)) {
                    for ($i = 0; $i < count($indexs); $i++) {
                        $index = $indexs[$i];
                        //primero verifica si hay archivos a subir
                        /*$nombreItem=Solicitud::getNombreItem($request->items[$i]);
                         $name= $numSolicitud.'-'.$nombreItem[0]->nombreItem; */
                        $name = $request->idSolicitud . '-' . $file[$index]->getClientOriginalName();
                        $type = $file[$index]->getMimeType();
                        $file[$index]->move($carpeta, $name);
                        //Guardo datos de documentos
                        $doc = new DetalleDocumentos();
                        $doc->urlArchivo = $carpeta . '\\' . $name;
                        $doc->tipoArchivo = $type;
                        //dd($doc->type);
                        $doc->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                        $doc->save();
                        $detalleDoc = DetalleDocumentos::all()->last();                   //obtengo el ultimo doc guardado
                        //Guardo el detalle documentos por solicitud
                        $docSol = new SolicitudesDocumentos();
                        $docSol->idSolicitud = $request->idSolicitud;
                        $docSol->idItemDoc = $index; //guardo el id del item de cada documentos. Le resto uno para que entre a la posiciones correctas del array

                        $docSol->idDetalleDoc = $detalleDoc->idDoc;
                        $docSol->save();


                    }
                }
            }

            //dd($file);
            //$solicitud = Solicitud::find($request->idSolicitud);
            //$solicitud->estado = 1;
            $solicitud->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
            $solicitud->save();

            DB::connection('sqlsrv')->commit();
            Session::flash('message', 'Se ingreso correctamente su Solicitud, su número de Solicitud es' . $solicitud->idSolicitud);
        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash('message', 'Sucedio un error al guardar su solicitud');
            return $e->getMessage();
        }

        $data = ['title' => 'Ver Solicitud', 'subtitle' => ''];
        $tramites = Solicitud::getTramites();
        $areas = Area::all()->where('estado', 'A');
        $marcas = Marca::all()->where('estado', 'A');
        $data['tramites'] = $tramites;
        $data['areas'] = $areas;
        $data['marcas'] = $marcas;

        return view('solicitudes.indexSolicitudes', $data);
    }

  public function savePresentacion(Request $request){

        if($request->clas==1){
           $messages = [
          'required' => 'El campo :attribute es requerido.',
          ];

          $v = Validator::make($request->all(),[
          'empaqueSec'   =>  'required',
          'materialSec'   =>  'required',
          'contenidoSec'    =>  'required'

          ], $messages);

          $v->setAttributeNames([
          'empaqueSec'   =>  'Empaque Secundario',
          'materialSec'   =>  'Material Secundario',
          'contenidoSec'    =>  'Contenido Secundario'
          ]);

        } else {
          $messages = [
          'required' => 'El campo :attribute es requerido.',
          ];

          $v = Validator::make($request->all(),[
          'empaquePri'   =>  'required',
          'materialPri'   =>  'required',
          'contenidoPri'    =>  'required',
          'unidad'    =>  'required',
          ], $messages);

          $v->setAttributeNames([
           'empaquePri'   =>  'Empaque Primario (EP)',
          'materialPri'   =>  'Material Primario (MP)',
          'contenidoPri' =>  'Contenido Primario',
          'unidad'    =>  'Medida',
          ]);

        }

         //Validaciones de sistema
            if ($v->fails())
            {
              $msg = "<ul class='text-warning'>";
              foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
              }
              $msg .= "</ul>";
                return response()->json(['status' => 404,'message' => 'Debe completar:', 'data' => ['message'=>$msg]]);
            }
       // $request->idsolicitud='325';
        DB::connection('sqlsrv')->beginTransaction();
        try{
              $presentacion= new SolicitudesPresentaciones();
              $presentacion->idSolicitud=$request->idsolicitud;
              $presentacion->idEnvasePrimario=$request->empaquePri;
              $presentacion->idMaterialPrimario=$request->materialPri;
              $presentacion->contenido=$request->contenidoPri;
              $presentacion->idUnidad=$request->unidad;
              if($request->empaqueSec!=''){
                $presentacion->idEnvaseSecundario=$request->empaqueSec;
              }
              if($request->materialSec!=''){
                $presentacion->idMaterialSecundario=$request->materialSec;
              }
              if($request->contenidoSec!=''){
                $presentacion->contenidoSecundario=$request->contenidoSec;
              }
             if($request->peso!=''){
                $presentacion->peso=$request->peso;
              }
              if($request->medida!=''){
                $presentacion->idMedida=$request->medida;
              }
              if($request->nombre!=''){
                $presentacion->nombrePresentacion=$request->nombre;
              }
              if($request->texto!=''){
                $presentacion->textoPresentacion=$request->texto;
              }
              $presentacion->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
              $presentacion->save();

         $presentacionesSol=SolicitudesPresentaciones::getPresentacionesSol($request->idsolicitud);
         //dd($presentacionesSol);
           DB::connection('sqlsrv')->commit();
          return response()->json(['status' => 200,'message' => 'Se ingreso presentación correctamente!', 'data' => ['presentaciones'=>$presentacionesSol]]);

        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 400,'message' => 'Error: no pudimos guardar su presentación!', 'data' => []]);
          /*  throw $e;*/
        }

      }

      public function deletePresentacion(Request $request){
        DB::connection('sqlsrv')->beginTransaction();
        try{
          $pres=SolicitudesPresentaciones::where('idPresentacion', $request->id)->where('idSolicitud',$request->idSolicitud)->delete();
          if($pres==1){
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se elimino presentación correctamente!', 'data' => []]);
          } else {
            return response()->json(['status' => 400,'message' => 'Error: no pudimos elimiinar su presentación!', 'data' => []]);
          }
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 404,'message' => 'Error: consulte con informatica!', 'data' => []]);
          /*  throw $e;*/
        }
      }

      public function getPresentacionesSolicitud(Request $request){
        $tipo=$request->tipo;
        $presentaciones=SolicitudesPresentaciones::getPresentacionesSol($request->idSol);

            return Datatables::of($presentaciones)
              ->addColumn('opciones',function($dt){
                return '<a class="btn btn-xs btn-danger borrarPres"><i class="fa fa-times" aria-hidden="true"></i></a>';

             })->rawColumns(['opciones'])
              ->make(true);

      }

      public function indexSolicitudes(){
          $data=['title'=>'ADMINISTRADOR DE SOLICITUDES',
          'subtitle'=>''];
          $data['estados']=EstadoSolicitud::activosAll();
          $data['tramites']=TiposTramites::acticosAll();
          return view('solicitudes.indexSolicitudes',$data);
      }

      public function getSolFavorables(){
          $data=['title'=>'ADMINISTRADOR DE SOLICITUDES FAVORABLES',
          'subtitle'=>''];
          return view('solicitudes.indexSolicitudesFavorables',$data);
      }

      public function getSolicitudes(Request $request)
      {
        $solicitudes=Solicitud::getSolicitudes();

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
            ->filter(function($query) use ($request){
              if($request->has('numsol')){
                   $query->where('s.numeroSolicitud','=',(string)$request->get('numsol'));
               }
               if($request->has('nomComercial')){

                   $query->where('sd.nombreComercial','like','%'.$request->get('nomComercial').'%');
               }
               if($request->has('idestado')){
                       $query->where('idEstado','=',(int)$request->get('idestado'));
               }
               if($request->has('idtipo')){
                $query->where('s.tipoSolicitud','=',(int)$request->get('idtipo'));
               }
               if($request->has('origen')){
                $query->where('s.solicitudPortal','=',(int)$request->get('origen'));
                }
               if($request->has('fecha')){
                  if($request->has('origen')){
                      if($request->get('origen')==0){
                        $query->where('s.fechaCreacion','like',"%". date('Y-m-d',strtotime($request->fecha))."%");
                      }else{
                        $query->where('s.fechaEnvio','like',"%". date('Y-m-d',strtotime($request->fecha))."%");
                      }
                  }else{
                    $query->where('s.fechaCreacion','like',"%". date('Y-m-d',strtotime($request->fecha))."%")->orwhere('s.fechaEnvio','like',"%". date('Y-m-d',strtotime($request->fecha))."%");
                  }
               }

            })->rawColumns(['opciones','diasTranscurridos','plazo'])
          ->make(true);

      }


      public function getSolicitudesFavorables(Request $request){
      //dd($request->idsesion);
          $solicitudes=Solicitud::getSolicitudesParaSesion($request->idsesion);
          return Datatables::of($solicitudes)
           ->addColumn('idSolicitud',function($dt){
              return '<a href="'.route('versolicitud',['idSolicitud'=>$dt->idSolicitud,'consultar'=>2]).'" class="btn btn-primary btn-sm"><b>'.$dt->idSolicitud.'</b></a>';
            })

            ->addColumn('agregar',function($dt){
              if($dt->estado=='FAVORABLE' || $dt->estado=='DESFAVORABLE'){
                 return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idSolicitud.'">';
               } else {
                 return '';
               }
            })->rawColumns(['idSolicitud','agregar'])
            ->make(true);
      }

      public function verSolicitud($id,$tipo,$solicitudPortal=null)
      {
        //$sol=collect(Solicitud::getSolicitudesPortal())->where('idTitular','PP1466');
        //dd(($sol));

        $data=['title'=>'SOLICITUD  #'.$id,
          'subtitle'=>''];

        $solicitud= Solicitud::find($id);//dd($solicitud->tipotramite->nombreTramite);

          if(empty($solicitud)){
             Session::flash('messageSol','La solicitud no se han cargado correctamente, Consulte con informática');
             return view ('solicitudes.indexSolicitudes',$data);
          }

          $nomTram=Solicitud::getNombreTramite($solicitud->tipoSolicitud);

          if(Empty($solicitud->detallesolicitud)){
             Session::flash('messageDet','El Detalle de la solicitud no se han cargado correctamente, Consulte con informática');
              return view ('solicitudes.indexSolicitudes',$data);
          }
          if($solicitud->detallesolicitud->idPoderProfesional===null){
           Session::flash('messageProf','Hay un problema con el poder de Profesional, Consulte con informática');
           return view ('solicitudes.indexSolicitudes',$data);
         }

        if($solicitud->tipoSolicitud==2||$solicitud->tipoSolicitud==3){ // si son tramite de cosmeticos
            $detalleCos = DetalleCosmetico::find($solicitud->detallesolicitud->idDetalle);
              if(Empty($detalleCos)){
                   Session::flash('messageCos','El Detalle del Cosmético no se han cargado correctamente, Consulte con informática');
                   return view ('solicitudes.indexSolicitudes',$data);
              } else{
                  //dd($detalleCos);
                  $aplica=ClasificacionCos::consultar($detalleCos->clasificacion->idClasificacion);
                  $data['detalleCos']=$detalleCos;
              }
              $formula=$solicitud->formulaCos;
              if($formula){
                  $array=[];
                  for($i=0; $i<count($formula); $i++){
                    $array[$i]=$solicitud->formulaCos->get($i)->sustancias()->first();
                  }
                  $sust = Collection::make($array);
                  $data['sust']=$sust;
                  $data['formula']=$formula;
               }
              //$formula=FormulaCosmetico::getSustanciasFormulaCos($solicitud->idSolicitud);

        } else { // si son higienicos

            $detalleHig = DetalleHigienico::getDetalleH($solicitud->detallesolicitud->idDetalle);

            if(Empty($detalleHig)){
              Session::flash('messageHig','El Detalle del Higienico no se han cargado correctamente, Consulte con informática');
                return view ('solicitudes.indexSolicitudes',$data);
                } else{
                  $aplica=ClasificacionHig::consultar($detalleHig[0]->idClasificacion);
                  $data['detalleHig']=$detalleHig;
               }
               $formula=$solicitud->formulaHig;
               if($formula){
                  $array=[];
                  for($i=0; $i<count($formula); $i++){
                    $array[$i]=$solicitud->formulaHig->get($i)->sustancias()->first();
                  }
                  $sust = Collection::make($array);
                  $data['sust']=$sust;
                  $data['formula']=$formula;
               }
               //$formula=FormulaHigienico::getSustanciasFormulaHig($solicitud->idSolicitud);
        }

          if($aplica[0]->poseeTono==1){ //buscos tonos y fragancias si la clasificacion aplica
              $tonos=$solicitud->tonos;
              $data['tonos']=$tonos;
          }
          if($aplica[0]->poseeFragancia==1){
              $frag=$solicitud->fragancias;
              $data['frag']=$frag;
          }

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

          $profesional=Solicitud::getProfesional($solicitud->detallesolicitud->idPoderProfesional);

          $fabNac=SolicitudFabricantes::getFabNacionalesSolicitud($solicitud->idSolicitud);

          $fabExt=SolicitudFabricantes::getFabExtranjerosSolicitud($solicitud->idSolicitud);

          $presentaciones=SolicitudesDetalle::getPresentaciones($id);

          $documentos=SolicitudesDetalle::getDocumentosSol($id);

          $distribuidores= Distribuidores::getDistribuidoresSol($id);

                 //dd($solicitud->detallesolicitud->idPoderProfesional);
          if(!$fabNac->isEmpty()){
            $data['fabricantesNac']=$fabNac;
          }

          if(!$fabExt->isEmpty()){
             $data['fabricantesExt']=$fabExt;
          }

          $importadores=SolicitudesDetalle::getImportadoresSol($id);

          if(!$importadores->isEmpty()){
            $data['importadores']=$importadores;
          }

          if(!$documentos->isEmpty()){
            $directory=File::dirname($documentos[0]->urlArchivo);
          }


          $data['distribuidores']=$distribuidores;
          $data['profesional']=$profesional;
          $data['documentos']=$documentos;
          $data['pais']=$solicitud->detallesolicitud->pais;
          $data['titular']=$titular;
          $data['solicitud']=$solicitud;
          $data['presentaciones']=$presentaciones;
          $data['tipo']=$tipo;
          $data['formula']=$formula;
          $data['nomTram']=$nomTram;
          $data['detalleSol'][0] = $solicitud->detallesolicitud();
          $persona=Solicitud::getPersonaN($solicitud->nitSolicitante);
          $persona[0]->telefonosContacto=json_decode($persona[0]->telefonosContacto);
          $data['persona']=$persona;

         // dd($persona);

          //dd($persona[0]->telefonosContacto[1]);

        if($tipo==1)
        {
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
        }
        elseif ($tipo==2)
        {
            $data['dictamenes'] = Dictamen::getResolucion($id);
        }

        if($solicitud->estado==11 || $solicitud->estado==4){
          $data['dictamenes'] = Dictamen::getResolucion($id);
        }

      Session::put('cfgHideMenu',true);


      /*  if(!empty($titular)||!empty($presentaciones)){
           Session::flash('message','Algunos datos del titular o presentaciones, no se han cargado correctamente, Consulte con informática');
          return view ('solicitudes.solicitudDetalle',$data);
       }*/
      if($tipo==1)
        return view ('solicitudes.solicitudDetalleDictamen',$data);
      else
        return view ('solicitudes.solicitudDetalle',$data);


      }


      public function getDocumentos($idDoc){

         $idDoc=Crypt::decrypt($idDoc);
         $documento=SolicitudesDetalle::getDocumento($idDoc);

         if($documento[0]!=null){


        if($documento[0]->tipoArchivo==='application/pdf'){
            //dd($documento);
            //parte nueva
        //$archivo->tipoArchivo='application/pdf';
            if(File::isFile($documento[0]->urlArchivo))
            {
                //dd($documento);
                $file = File::get($documento[0]->urlArchivo);
                //dd($file);
                $response = Response::make($file, 200);
                //dd($documento[0]->nombreItem);
                // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
                $response->header('Content-Type', 'application/pdf');
                //$response->header('Content-Disposition','inline;'.$documento[0]->nombreItem);


                return $response;
            }
          }
        }
      }

      public function actualizarSolicitud($id,$tipo,$tipoSol){
        $data=['title'=>'SOLICITUD  #'.$id,
          'subtitle'=>''];

        $Solicitud= Solicitud::find($id);
        $formular = [];
        if($Solicitud->tipoSolicitud == 2 || $Solicitud->tipoSolicitud == 3)
        {
          $formula=FormulaCosmetico::getSustanciasFormulaCos($Solicitud->idSolicitud);
        }
        else
        {
          $formula=FormulaHigienico::getSustanciasFormulaHig($Solicitud->idSolicitud);
        }

          $fabNac=SolicitudFabricantes::getFabNacionalesSolicitud($Solicitud->idSolicitud);

          $fabExt=SolicitudFabricantes::getFabExtranjerosSolicitud($Solicitud->idSolicitud);


          $documentos=SolicitudesDetalle::getDocumentosSol($id);
          $items=Solicitud::getItems($Solicitud->tipoSolicitud);



          foreach ($items as $item) {
            $item->poseeDoc=0;
            foreach ($documentos as $docs) {
              if($item->idItem==$docs->idItemDoc){
                $item->poseeDoc=1;
                $item->idDoc=$docs->idDoc;
              }
            }
          }



          $data['anexos']=$items;

          $distribuidores= Distribuidores::getDistribuidoresSol($id);

          $data['fabricantesNac']=$fabNac;

          $data['fabricantesExt']=$fabExt;

          $importadores=SolicitudesDetalle::getImportadoresSol($id);

          $clasificacionesHig=ClasificacionHig::getClasHig();

          $data['clashig']=$clasificacionesHig;

          //dd($Solicitud->detallesolicitud->detallehigienico->idClasificacion);

          $data['importadores']=$importadores;

          if(!$documentos->isEmpty()){
            $directory=File::dirname($documentos[0]->urlArchivo);
          }

          $data['distribuidores']=$distribuidores;
          $data['documentos']=$documentos;

          $data['solicitud']=$Solicitud;
          $data['tipoSol']=$tipoSol;
          $marcas=Marca::where('estado','A')->orderBy('nombreMarca','ASC')->get();
          $data['marcas']=$marcas;
          $areas=Area::all()->where('estado','A');
          $data['areas']=$areas;

          $data['formula'] = $formula;
          $mandamiento= Solicitud::getMandamiento($Solicitud->idMandamiento);

          $data['mandamiento']=$mandamiento;
          $data['presentaciones'] = SolicitudesDetalle::getPresentaciones($id);
          //dd($Solicitud->detallesolicitud);
          if($Solicitud->tipoSolicitud==2 || $Solicitud->tipoSolicitud==3){
            $data['idclas']=$Solicitud->detallesolicitud->detallecosmetico->idClasificacion;
            $data['idforma']=$Solicitud->detallesolicitud->detallecosmetico->idFormaCosmetica;
          } else {

            $data['idclas']=$Solicitud->detallesolicitud->detallehigienico->idClasidicacion;
            $data['idforma']=0;
          }


          return view ('solicitudes.solicitudEditar',$data);


      }

      public function actualizarSol(Request $request){

        $messages = [
          'nombreComercial.required' => 'El campo :attribute es requerido.',
          'id_propietario.required' => 'Debe seleccionar un propietario.',
          'ID_PROFESIONAL.required' => 'Debe seleccionar un profesional responsable',
          'idPersona.required'=>'Debe seleccionar una persona para contacto',
          'mandamiento.required'=>'Debe ingresar un mandamiento de pago válido',
          ];

        $rules=[
              'nombreComercial'   =>  'required',
              'id_propietario'   =>  'required',
              'ID_PROFESIONAL'=>'required',
              'nitContacto'=>'required',
              'mandamiento'=>'required'
            ];

        if($request->coempaque==1){
          $messages+=['nomCoempaque.required' => 'El campo Detalle el Nombre Comercial del otro producto que compone el coempaque es requerido.',];
          $rules+=['nomCoempaque'=>'required'];
        }

        if($request->idTramite==3||$request->idTramite==5){
            $messages+=[ 'paisOrigen.required' => 'El campo :attribute es requerido.',
                         'numRegistro.required' => 'El campo :attribute es requerido.',
                         'fechaVen.required' => 'El campo :attribute es requerido.',];
            $rules+=['paisOrigen'=>'required',
                      'numRegistro'=>'required',
                      'fechaVen'=>'required'];

        }

        if($request->idTramite==2||$request->idTramite==3){

              $messages+=[ 'class.required' => 'Debe seleccionar una clasificación.',
                          'forma.required' => 'Debe seleccionar una forma cosmética.',];

              $rules+=[ 'class'   =>  'required',
                        'forma'   =>  'required',];

        } else {
              $messages+=[ 'uso.required' => 'Debe ingresar el uso del Higienico.',
                           'classH.required' => 'Debe seleccionar una clasificación.',];

              $rules+=[ 'uso'   =>  'required',
                        'classH'   =>  'required',];
        }

          $v = Validator::make($request->all(),$rules, $messages);

          $v->setAttributeNames([
          'nombreComercial'   =>  'Nombre Comercial',
          'paisOrigen'=>'Pais de Origen',
          'fechaVen'=>'Fecha de Vencimiento'
          ]);

          if ($v->fails())
            {
              $msg = "<ul class='text-warning'>";
              foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
              }
              $msg .= "</ul>";
                return response()->json(['status' => 404,'message' => 'Debe completar:', 'data' => ['message'=>$msg]]);
            }


          $data=['title'=>'Ver Solicitud',
              'subtitle'=>''];
          $tramites=Solicitud::getTramites();
          $areas=Area::all()->where('estado','A');
          $marcas=Marca::all()->where('estado','A');
          $data['tramites']=$tramites;
          $data['areas']=$areas;
          $data['marcas']=$marcas;

          DB::connection('sqlsrv')->beginTransaction();
          try{
            $solicitud= Solicitud::find($request->idSol);    //Guardo Solictud
            //$solicitud->tipoSolicitud=$request->idTramite;
            $solicitud->idMandamiento=$request->mandamiento;
            $solicitud->nitSolicitante=$request->nitContacto;
            //$solicitud->idUsuarioCrea=Auth::User()->idUsuario;
            $solicitud->poseeCoempaque=$request->coempaque;
            $solicitud->descripcionCoempaque=$request->nomCoempaque;
            //$solicitud->estado=1;
            $solicitud->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
            $solicitud->save();


            $detalle=SolicitudesDetalle::find($request->idSol);                       //Guardo el detalle con el id de la solicitud ingresada.
            //$detalle->idSolicitud=$solicitud->idSolicitud;
            $detalle->tipoTitular=$request->tipoT;
            $detalle->nombreComercial=$request->nombreComercial;
            $detalle->idMarca=$request->marca;
            $detalle->idTitular=$request->id_propietario;
            $detalle->idProfesional=$request->ID_PROFESIONAL;
            $detalle->idPoderProfesional=$request->poderProfesional;
            //$detalle->idUsuarioCrea=Auth::User()->idUsuario;

              if($request->idTramite=='3'||$request->idTramite=='5'){         //verifico si el tramite es Reconocimiento
                  $detalle->idPais=$request->paisOrigen;
                  $detalle->numeroRegistroExtr=$request->numRegistro;
                  $detalle->fechaVencimiento=$request->fechaVen;
              } else {
                $detalle->idPais=222;                                   // pais 2= El salvador
              }
            $detalle->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
            $detalle->save();                                         //Guardo datos del reconocimiento

           $numDetalle= SolicitudesDetalle::find($request->idDetalleSol);
           //Guardo detalle de Cosmetico o higienico, busco detalle guardado

            if($request->idTramite==2||$request->idTramite==3){    // tramite nuevo registro o reconocimiento cosmetico guardo detalle cosmetico

              $detalleCos=DetalleCosmetico::find($request->idDetalleSol);
              //$detalleCos->idDetalle=$numDetalle->idDetalle;
              $detalleCos->idClasificacion=$request->class;
              $detalleCos->idFormaCosmetica=$request->forma;
              $detalleCos->idUsuarioModifica=Auth::user()->idUsuario.'@'.$request->ip();
              $detalleCos->save();
              }
             if($request->idTramite==4||$request->idTramite==5){ //tramite nuevo registro o reconocimiento higienico guardo detalle cosmetico
              $detalleHig=DetalleHigienico::find($request->idDetalleSol);
              //$detalleHig->idDetalle=$numDetalle->idDetalle;
              $detalleHig->idClasificacion=$request->classH;
              $detalleHig->uso=$request->uso;
              $detalleHig->idUsuarioModifica=Auth::user()->idUsuario.'@'.$request->ip();
              $detalleHig->save();
              }


            DB::connection('sqlsrv')->commit();
             return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => ['idSolicitud'=>$solicitud->idSolicitud]]);

        }  catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => ['error',$e]]);

        }

      }

      public function eliminarDocumento(Request $request){
        //$idDoc=Crypt::decrypt($idDoc);
        //dd($request);
        DB::connection('sqlsrv')->beginTransaction();
        try{
          $documento=DetalleDocumentos::find($request->idDoc);
          $urlArchivo=$documento->urlArchivo;
          $doc=DetalleDocumentos::where('idDoc',$request->idDoc)->delete();
          $filesystem= new Filesystem();
          $filesystem->delete($urlArchivo);

        if($doc==1){
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se elimino el documento correctamente!', 'data' => []]);
          } else {
            return response()->json(['status' => 400,'message' => 'Error: no pudimos eliminar su documento!', 'data' => []]);
          }
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 404,'message' => 'Error: consulte con informatica!', 'data' => []]);
          /*  throw $e;*/
        }
        //dd($idDoc);
      }

      public function ingresarFormula(Request $request){
      //  dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try{
                $solicitud= Solicitud::find($request->idsol);
                if($solicitud->tipoSolicitud==2 || $solicitud->tipoSolicitud==3){
                   $formula = new FormulaCosmetico();
                   $formula->idDenominacion=$request->id;
                   $formula->idSolicitud=$request->idsol;
                   $formula->porcentaje=$request->por;
                   $formula->idUsuarioCreacion=Auth::user()->idUsuario.'@'.$request->ip();
                   $formula->save();
                   $form=FormulaCosmetico::getFormulaINCI($formula->idDenominacion);
                 //dd($form->numeroCAS);

                } else {
                  $formula= new FormulaHigienico();
                  $formula->idDenominacion=$request->id;
                  $formula->idSolicitud=$request->idsol;
                  $formula->porcentaje=$request->por;
                  $formula->idUsuarioCreacion=Auth::user()->idUsuario.'@'.$request->ip();
                  $formula->save();
                  $form=FormulaHigienico::getFormulaHig($formula->idDenominacion);
                }
                //dd($formula->idCorrelativo);

             DB::connection('sqlsrv')->commit();

            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => ['form'=>$formula,'form1'=>$form]]);

             } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }


      public function eliminarFormula(Request $request){

        DB::connection('sqlsrv')->beginTransaction();
        try{
          $solicitud= Solicitud::find($request->idsol);
          if($solicitud->tipoSolicitud==2 || $solicitud->tipoSolicitud==3)
            $form=FormulaCosmetico::where('idCorrelativo',$request->id)->delete();
          else
            $form=FormulaHigienico::where('idCorrelativo',$request->id)->delete();

        if($form==1){
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se elimino la formula correctamente!', 'data' => []]);
          } else {
            return response()->json(['status' => 400,'message' => 'Error: no pudimos eliminar la formula!', 'data' => []]);
          }
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 404,'message' => 'Error: consulte con informatica!', 'data' => []]);
          /*  throw $e;*/
        }
        //dd($idDoc);
      }

      public function eliminarFragancia(Request $request){
        //$idDoc=Crypt::decrypt($idDoc);
        //dd($request);
        DB::connection('sqlsrv')->beginTransaction();
        try{
          //$form=FormulaCosmetico::find($request->id);
          //$urlArchivo=$documento->urlArchivo;
          $frag=SolicitudesFragancias::where('idFragancia',$request->id)->delete();


        if($frag==1){
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se elimino la fragancia correctamente!', 'data' => []]);
          } else {
            return response()->json(['status' => 400,'message' => 'Error: no pudimos eliminar la fragancia!', 'data' => []]);
          }
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 404,'message' => 'Error: consulte con informatica!', 'data' => []]);
          /*  throw $e;*/
        }
        //dd($idDoc);
      }

      public function eliminarTono(Request $request){
        //$idDoc=Crypt::decrypt($idDoc);
        //dd($request);
        DB::connection('sqlsrv')->beginTransaction();
        try{
          //$form=FormulaCosmetico::find($request->id);
          //$urlArchivo=$documento->urlArchivo;
          $tono=SolicitudesTonos::where('idTono',$request->id)->delete();


        if($tono==1){
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se elimino el tono correctamente!', 'data' => []]);
          } else {
            return response()->json(['status' => 400,'message' => 'Error: no pudimos eliminar el tono!', 'data' => []]);
          }
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 404,'message' => 'Error: consulte con informatica!', 'data' => []]);
          /*  throw $e;*/
        }
        //dd($idDoc);
      }


}
