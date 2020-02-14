<?php

namespace App\Http\Controllers;
use App\Models\Higienico;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Session;
use DB;
use App\Models\ClasificacionHig;
use App\Models\Propietario;
use Auth;
use Crypt;
use App\Models\Higienicos\FormulaHigienicos;
use App\Models\Higienicos\TonosHigienicos;
use App\Models\Higienicos\FraganciasHigienicos;
use App\Models\Higienicos\FabricantesHigienicos;
use App\Models\Higienicos\DistribuidoresHigienicos;
use App\Models\Higienicos\ImportadoresHigienicos;
use App\Models\Higienicos\ProfesionalesHigienicos;
use App\Models\Higienicos\PresentacionesHigienicos;
use App\Models\FormulaHigienico as FH;
use App\Models\Marca;
use App\Models\Pais;
use App\Models\Solicitud;
use App\Models\VwPropietario;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Validator;

class HigienicoController extends Controller {
	  public  function index(){
    	$data=['title'=>'Catálogo de Higiénicos',
    			'subtitle'=>''];

        $allPaises = Pais::where('activo','A')->select('codigoId','nombre')->get();
        $data['allPaises'] = $allPaises;

    	return view ('higienicos.indexHigienicos',$data);
    }

    public function getCrearClas(){
        $data=['title'=>'Catálogo de Higiénicos',
          'subtitle'=>''];
        return view ('clasificacion.crearHig',$data);
    }

    public function indexSustancias(){
        $data=['title'=>'Catálogo de Sustancias para productos Higiénicos',
          'subtitle'=>''];
        return view ('sustancias.indexHig',$data);
    }

    public function getSustanciasHig(){
        $data=['title'=>'Catálogo Sustancia para Producto de Higiénicos',
            'subtitle'=>''];

        $sustancia=FH::getSustanciasHig();
        return Datatables::of($sustancia)
                ->make(true);

    }

    public function verClasificiones(){
        $data=['title'=>'Catálogo de Higiénicos',
          'subtitle'=>''];
        return view ('clasificacion.indexHig',$data);
    }

    public function editar($id){
      $data=['title'=>'Catálogo de Higiénicos',
          'subtitle'=>''];
      $class=ClasificacionHig::find($id);
      $data['class']=$class;
      return view ('clasificacion.editarHig',$data);

    }

    public function saveClassHig(Request $request){
        $data=['title'=>'Catálogo de Higiénicos',
          'subtitle'=>''];

        $class=new ClasificacionHig();
        $class->nombreClasificacion=strtoupper($request->nombre);
        $class->poseeTono=$request->tono;
        $class->poseeFragancia=$request->fragancia;
        $class->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
        $class->save();

        Session::flash('message','Se ha creado Clasificación');
         return view('clasificacion.indexHig',$data);
    }

      public function getClasificaciones(){
        $data=['title'=>'Catálogo de Higienicos',
        'subtitle'=>''];

        $classHig=ClasificacionHig::getClasHigienicos();
        return Datatables::of($classHig)
            ->addColumn('opciones',function($dt){
              return '<a href="'.route('editarClassHig',['idClasificacion'=>$dt->idClasificacion]).'" class="btn btn-info"><b>EDITAR</b></a>';
            })->rawColumns(['opciones'])
            ->make(true);
    }

    public  function dtRowDataHig(Request $request){
    	$data=['title'=>'Catálogo de Higienicos',
    		'subtitle'=>''];

        //$higienicos=Higienico::getHigienicos();
        $higienicos = DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.Higienicos as h')
                    ->leftJoin('dnm_cosmeticos_si.HIG.profesionalesHigienicos as ph','ph.idHigienico','=','h.idHigienico')
                    ->select('h.idHigienico','h.nombreComercial',DB::raw("CASE when h.estado='A' then
                    'ACTIVO' else 'INACTIVO' END as estado"),'h.vigenteHasta',DB::raw("CASE when h.tipo=1 then
                    'REGISTRO HIGIENICO' else 'RECONOCIMIENTO HIGIENICO' END as tipo"),'ph.idPoder')
                    ->distinct();
        return Datatables::of($higienicos)
        		->addColumn('opciones',function($dt){
        			return '<a href="'.route('verhigienico',['idHigienico'=>Crypt::encrypt($dt->idHigienico),'opcion'=>Crypt::encrypt(0)]).'" class="btn btn-primary btn-sm"><b>VER</b></a> <a href="'.route('verhigienico',['idHigienico'=>Crypt::encrypt($dt->idHigienico), 'opcion'=>Crypt::encrypt(1)]).'" class="btn btn-info btn-sm"><b>EDITAR</b></a> ';
        		})
                ->filter(function($query) use ($request){
                    if($request->has('nhigienico'))
                        $query->where('h.idHigienico',$request->get('nhigienico'));

                    if($request->has('nomComercial'))
                        $query->where('h.nombreComercial','like','%'.$request->get('nomComercial').'%');

                    if($request->has('tipo'))
                        $query->where('tipo',$request->get('tipo'));

                    if($request->has('titular'))
                        $query->where('h.idTitular',$request->get('titular'));

                    if($request->has('profesional'))
                        $query->where('ph.idProfesional',$request->get('profesional'));

                    if($request->has('fabricante')){
                        $fab = FabricantesHigienicos::where('idFabricante',$request->fabricante)->distinct()->pluck('idHigienico');
                        $query->whereIn('h.idHigienico', $fab);
                    }

                    if($request->has('idPais'))
                        $query->where('h.idPaisOrigen',$request->idPais);

                })->rawColumns(['opciones'])
        		->make(true);

    }
    public function actualizarClass(Request $request){
        $data=['title'=>'Catálogo de Higienicos',
        'subtitle'=>''];

        $clasificacion=ClasificacionHig::find($request->id);
        $clasificacion->nombreClasificacion=strtoupper($request->nombre);
        $clasificacion->poseeFragancia=(int)$request->fragancia;
        $clasificacion->poseeTono=(int)$request->tono;

        $clasificacion->estado=$request->estado;
        $clasificacion->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
        $clasificacion->save();


        Session::flash('message','Clasifiación actualizada con éxito');
        return view('clasificacion.indexHig',$data);
    }

    public function verhigienico($id,$opcion){
        $data=['title'=>'Catálogo de Higiénico',
		    		'subtitle'=>''];
        $data['fab']=null;
        $data['pro']=null;
        $data['pp']=null;

        $id=Crypt::decrypt($id);
        $opcion=Crypt::decrypt($opcion);
        $paises=Pais::where('activo','A')->select('codigoId','nombre')->orderby('nombre')->get();

        //--Busco las generales del producto--//
        $higienico=Higienico::findOrFail($id);
        //$higienico->clasificacion=$higienico->clasificacion()->where('estado','I')->first();

        $fabri=Higienico::existeFabri($id);
        if ((count($fabri))>0){
          $fabricantes=Higienico::getFabricantes($id);
          $data['fab']=$fabricantes;
        }
        /*
        $prof=Higienico::existeProf($id);
        if ((count($prof))>0){
          $profesional=Higienico::getProfesional($id);
          //dd($profesional);
          $data['pro']=$profesional;
        }*/

        $prof = $higienico->profesional;
        if (!empty($prof)) {
            if(!empty($prof->idProfesional) && !empty($prof->idPoder)){
                $profesional = Higienico::getProfesional($prof->idProfesional,$prof->idPoder);
                $data['pro'] = $profesional;
            }
        }

        //--Busco el propietario con el idTItular--//
        if(!empty($higienico->tipoTitular) && !empty($higienico->idTitular)) {
            if ($higienico->tipoTitular != 3) {
                if (VwPropietario::find($higienico->idTitular) != null) {
                    $propietario = Propietario::getTitular($higienico->idTitular, $higienico->tipoTitular);
                    $data['pp'] = $propietario;
                }
            } else {
                if (Propietario::find($higienico->idTitular) != null) {
                    $propietario = Propietario::getTitular($higienico->idTitular, $higienico->tipoTitular,1);
                    $data['pp'] = $propietario;
                }
            }
        }

        $importadores=Higienico::getImportadores($id);
        $distribuidores=Higienico::getDistribuidoresHig($id);
        $fragancias=Higienico::find($id)->fragancias;
        $tonos=Higienico::find($id)->tonos;
        $pres=$higienico->presentaciones;

        //--Extraigo Formula--//
        $formula=$higienico->formula;
        $array=[];

        if($formula){
          for($i=0; $i<count($formula); $i++){
            $array[$i]=$higienico->formula->get($i)->sustancias()->first();
          }
        $sust = Collection::make($array);
        $data['sust']=$sust;
        $data['formula']=$formula;
        }

        //--Extraigo tipo de producto--//
        if($higienico->tipo==1){
            $higienico->tipoProducto='REGISTRO HIGIÉNICO';
        } else {
            $higienico->tipoProducto='REGISTRO RECONOCIMIENTO HIGIÉNICO';
        }
        if($higienico->estado[0]=='A'){
            $higienico->estado='ACTIVO';
        } else {
            $higienico->estado='INACTIVO';
        }

       // Busco el propietario//
       if($higienico->tipoTitular!=3){ // si es natural busco el id propietario para enviarlo a odin
            if(VwPropietario::find($higienico->idTitular)!=null){
              //$prop=Propietario::where('NIT',$higienico->idTitular)->get();
              $propietario=Propietario::getTitular($higienico->idTitular,$higienico->tipoTitular);
              //dd($higienico->tipoTitular);
            } else {
              $propietario=0;
            }
        } else {
            if(Propietario::find($higienico->idTitular)!=null){
              $propietario=Propietario::getTitular($higienico->idTitular,$higienico->tipoTitular);
            } else {
              $propietario=0;
            }
        }

        if($fragancias->isEmpty()||$tonos->isEmpty()||$pres->isEmpty()||$importadores->isEmpty()||$distribuidores->isEmpty()){
            Session::flash('message','Este producto no posee registros');
        }

        $data['clasificacionProd']='HIG'; // PARA SABER SI ES COS O HIG EN CONSULTAS
      	$data['hig']=$higienico;
      	$data['pp']=$propietario;
        $data['pais']=$higienico->pais;
      	$data['pres']=$pres;
      	$data['fra']=$fragancias;
        $data['tonos']=$tonos;
        $data['imp']=$importadores;
        $data['dis']=$distribuidores;
        $data['paises']=$paises;
        //dd($propietario);

        if($opcion==0)
            return view ('higienicos.detalleHigienico',$data);
        else if($opcion==1) {
            $marcas = Marca::all()->where('estado', 'A');
            $data['marcas'] = $marcas;
            $clasificaciones = ClasificacionHig::all()->where('estado', 'A');
            $data['clasificaciones'] = $clasificaciones;
        }
        else{
            return view ('higienicos.tabsHigienico',$data);
        }

        //dd($data);
        return view ('higienicos.detalleHigienicoEditar',$data);

    }

    public function editarGenerales(Request $request){
        //dd($request);
        $messages = [
          'required' => 'Debe seleccionar un :attribute.'

          ];

        $rules=['idHigienico'=>'required',
                'nombreComercial'=>'required',
                'vigenciaHasta'=>'required',
                'renovacion'=>'required',
                'estado'=>'required',
                'actualizado' => 'required'
                ];

        $nombres=[
                'idHigienico'=>'Número de Registro',
                'nombreComercial'=>'Nombre Comercial',
                'vigenciaHasta'=>'Fecha de Vigencia',
                'renovacion'=>'Fecha de Renovación',
                'estado'=>'Estado',
                'actualizado' => 'Actualizado'
          ];

        if($request->idtipo==2){
            $rules+=[
                    'numeroReconocimiento'=>'required',
                    'fechaVencimiento'=>'required'
                    ];

            $nombres+=[
                'numeroReconocimiento'=>'Número de Registro en País Origen',
                'fechaVencimiento'=>'Fecha de Vencimiento'

            ];
        }

        $validacion=Validator::make($request->all(),$rules,$messages);
        $validacion->setAttributeNames($nombres);

         if ($validacion->fails()){
            $msg = "<ul>";
            foreach ($validacion->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 404, 'message' => $msg]);
        }
     //dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try{
            $higienico=Higienico::find($request->idHigienico);
            if($request->idtipo==2){
                $higienico->numeroReconocimiento=$request->numeroReconocimiento;
                $higienico->VencimientoRec=$request->fechaVencimiento;
                //$higienico->idPaisOrigen=$request->idPais;
            }
            $higienico->nombreComercial = $request->nombreComercial;
            $higienico->idPaisOrigen=$request->idPais;
            $higienico->vigenteHasta=date('Y-m-d', strtotime($request->vigenciaHasta));

            $higienico->renovacion=date('Y-m-d', strtotime($request->renovacion));
             //Cambiando valores de actualización solo cuando se escoge desde el select
            if ($higienico->actualizado != $request->actualizado) {
               $higienico->actualizado=$request->actualizado;
               $higienico->fechaActualizado=Carbon::now('America/El_Salvador');
            }
            $higienico->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
            $higienico->estado=$request->estado;
            $higienico->save();

            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }

    public function editarPropietario(Request $request){
       // dd($request);
         $rules=['idTitular'=>'required'
                ];

        $message=['idTitular.required'=>'Debe seleccionar un Propietario'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try{

             $higienico=Higienico::find($request->NoRegistro);
             $higienico->tipoTitular=$request->titularTipo;
             if($request->titularTipo!=3)
                $higienico->idTitular=$request->nit;
             else
                $higienico->idTitular=$request->idTitular;
             $higienico->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
             $higienico->save();

             DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

             } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

     public function editarProfesional(Request $request){
       // dd($request);
          $rules=['idPoderprof'=>'required'
                ];

        $message=['idPoderprof.required'=>'Debe seleccionar un Poder de Profesional'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try{
             DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.HIG.profesionalesHigienicos where idHigienico = ?',[$request->NoRegistro]);

             $higienicoProf=new profesionalesHigienicos();
             $higienicoProf->idHigienico=$request->NoRegistro;
             $higienicoProf->idPoder=$request->idPoderprof;
             $higienicoProf->idProfesional=$request->idProfesional;
             $higienicoProf->idUsuarioCrea=Auth::user()->idUsuario.'@'.$request->ip();
             //$cosmetico->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
             $higienicoProf->save();

             DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

             } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarClasificacion(Request $request){
       //dd($request);
        $rules=['clasificacion'=>'required',
                'uso'=>'required'];

        $message=['clasificacion.required'=>'Debe seleccionar una Clasificación Válida',
                  'uso.required'=>'Debe seleccionar un Uso Válido'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try{
            $higienico=Higienico::find($request->NoRegistro);
            $higienico->idClasificacion=$request->clasificacion;
            $higienico->uso=$request->uso;
            $higienico->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
            $higienico->save();
            DB::connection('sqlsrv')->commit();
           return response()->json(['status' => 200,'message' => 'Resultado con exito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado ese Registro Cosméticos!', 'data' => []]);
        }

    }

    public function editarMarca(Request $request){
        $rules=['marca'=>'required'
                ];

        $message=['marca.required'=>'Debe seleccionar una Marca Válida'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try{
             $higienico=Higienico::find($request->NoRegistro);
             $higienico->idMarca=$request->marca;
             $higienico->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
             $higienico->save();

             DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

             } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }


    }

    public function editarFormula(Request $request){
      //  dd($request);
        $rules=['idDenominacion'=>'required'
                ];

        $message=['idDenominacion.required'=>'Debe seleccionar una sustancia para la formula'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try{

             DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.HIG.FormulaHigienico where idHigienico = ?',[$request->NoRegistro]);

             for($i=0;$i<count($request->idDenominacion);$i++){
                 $higienicoFormula = new FormulaHigienicos();
                 $higienicoFormula->idDenominacion=$request->idDenominacion[$i];
                 $higienicoFormula->idHigienico=$request->NoRegistro;
                 $higienicoFormula->porcentaje=$request->porcentaje[$i];
                 $higienicoFormula->idUsuarioCreacion=Auth::user()->idUsuario.'@'.$request->ip();
                 $higienicoFormula->save();
            }
             DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

             } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

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
              $presentacion= new PresentacionesHigienicos();
              $presentacion->idHigienico=$request->idHigienico;
              $presentacion->idEnvasePrimario=$request->empaquePri;
              $presentacion->idMaterialPrimario=$request->materialPri;
              $presentacion->contenidoPrimario=$request->contenidoPri;
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

         $presentacionesHig=PresentacionesHigienicos::getPresentacionesHig($request->idHigienico);
         $presentacionesHig->total=count($presentacionesHig);
         //dd($presentacionesCos);
           DB::connection('sqlsrv')->commit();
          return response()->json(['status' => 200,'message' => 'Se ingreso presentación correctamente!', 'data' => ['presentaciones'=>$presentacionesHig]]);

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
          $pres=PresentacionesHigienicos::where('idPresentacion', $request->idPresentacion)->where('idHigienico',$request->idHigienico)->delete();
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

      public function getPresentacionesHigienicos(Request $request){
        $tipo=$request->tipo;
        $presentaciones=PresentacionesHigienicos::getPresentacionesHig($request->idHig);

            return Datatables::of($presentaciones)
              ->addColumn('opciones',function($dt){
                return '<a class="btn btn-xs btn-danger borrarPres"><i class="fa fa-times" aria-hidden="true"></i></a>';

             })->rawColumns(['opciones'])
              ->make(true);

      }

    public function editarTonos(Request $request){

        $rules=['tonos'=>'required'
                ];

        $message=['tonos.required'=>'Debe seleccionar un Tono'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
       // dd($request);

       DB::connection('sqlsrv')->beginTransaction();
        try{

             DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.HIG.tonosHigienicos where idHigienico = ?',[$request->NoRegistro]);

            for($i=0;$i<count($request->tonos);$i++){
             $higienicoTonos=new TonosHigienicos();
             $higienicoTonos->idHigienico=$request->NoRegistro;
             $higienicoTonos->tono=$request->tonos[$i];
             $higienicoTonos->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
             $higienicoTonos->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarFragancias(Request $request){


        $rules=['fragancias'=>'required'];

        $message=['fragancias.required'=>'Debe seleccionar al menos una Fragancia'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
       // dd($request);

       DB::connection('sqlsrv')->beginTransaction();
        try{

             DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.HIG.fraganciasHigienicos where idHigienico = ?',[$request->NoRegistro]);

            for($i=0;$i<count($request->fragancias);$i++){
             $higienicoFragancias=new FraganciasHigienicos();
             $higienicoFragancias->idHigienico=$request->NoRegistro;
             $higienicoFragancias->fragancia=$request->fragancias[$i];
             $higienicoFragancias->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
             $higienicoFragancias->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarFabricantes(Request $request){

        $rules=['fabricantes'=>'required'];

        $message=['fabricantes.required'=>'Debe seleccionar al menos un fabricante'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
       // dd($request);

       DB::connection('sqlsrv')->beginTransaction();
        try{

             DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.HIG.fabricantesHigienicos where idHigienico = ?',[$request->NoRegistro]);

            for($i=0;$i<count($request->fabricantes);$i++){
             $higienicoFab=new FabricantesHigienicos();
             $higienicoFab->idHigienico=$request->NoRegistro;
             $higienicoFab->idFabricante=$request->fabricantes[$i];
             $higienicoFab->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
             $higienicoFab->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }

    public function editarDistribuidores (Request $request){

        $rules=['poderDistribuidores'=>'sometimes'];

        $message=['poderDistribuidores.sometimes'=>'Debe seleccionar al menos un Distribuidor'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
      //  dd($request);

       DB::connection('sqlsrv')->beginTransaction();
        try{
            $pro=Higienico::find($request->NoRegistro);
            $pro->distribuidores()->delete();
            if($request->has('poderDistribuidores')){
                    for($i=0;$i<count($request->poderDistribuidores);$i++){
                     $higienicoFab=new DistribuidoresHigienicos();
                     $higienicoFab->idHigienico=$request->NoRegistro;
                     $higienicoFab->idPoder=$request->poderDistribuidores[$i];
                     $higienicoFab->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
                     $higienicoFab->save();
                    }
            }
            if($request->has('disTitu')){
                $pro->distribuidorTitular=$request->disTitu;
                $pro->idUsuarioModificacion= Auth::User()->idUsuario . '@' . $request->ip();
                $pro->save();
            }

            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }

    public function editarImportadores(Request $request){
        $rules=['importadores'=>'required'];

        $message=['importadores.required'=>'Debe seleccionar al menos un Importador'];

        $validacion=Validator::make($request->all(),$rules,$message);
        if($validacion->fails()){
            return response()->json(['status' => 404,'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
      //  dd($request);

       DB::connection('sqlsrv')->beginTransaction();
        try{

             DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.HIG.importadoresHigienicos where idHigienico = ?',[$request->NoRegistro]);

            for($i=0;$i<count($request->importadores);$i++){
             $higienicoImp=new ImportadoresHigienicos();
             $higienicoImp->idHigienico=$request->NoRegistro;
             $higienicoImp->idImportador=$request->importadores[$i];
             $higienicoImp->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
             $higienicoImp->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400,'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }
}