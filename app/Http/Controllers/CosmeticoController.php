<?php

namespace App\Http\Controllers;

use App\Models\Cosmetico;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Session;
use DB;
use App\Models\Cosmeticos\PresentacionesCosmeticos;
use App\Models\SustanciaCosmetico;
use App\Models\Coempaques;
use App\Models\SustanciaHigienico;
use App\Models\Cosmeticos\FormulaCosmeticos;
use App\Models\Cosmeticos\ProfesionalesCosmeticos;
use App\Models\Cosmeticos\TonosCosmeticos;
use App\Models\DetalleCoempaques;
use App\Models\Cosmeticos\FabricantesCosmeticos;
use App\Models\Cosmeticos\FraganciasCosmeticos;
use App\Models\Cosmeticos\DistribuidoresCosmeticos;
use App\Models\FormulaHigienico;
use App\Models\Cosmeticos\ImportadoresCosmeticos;
use App\Models\Propietario;
use App\Models\Area;
use App\Models\Marca;
use App\Models\Solicitud;
use App\Models\ProfesionalesPoderes;
use App\Models\VwPropietario;
use App\Models\Pais;
use Auth;
use Crypt;
use Validator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class CosmeticoController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Catálogo de Cosméticos',
            'subtitle' => ''];
        $allPaises = Pais::where('activo','A')->select('codigoId','nombre')->get();
        $data['allPaises'] = $allPaises;
        return view('Cosmeticos.indexCosmeticos', $data);
    }

    public function dtRowDataCos(Request $request)
    {
        $data = ['title' => 'Catálogo de Cosméticos',
            'subtitle' => ''];

        //$cosmeticos = Cosmetico::getCosmeticos();
        $cosmeticos = DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.Cosmeticos as c')
            ->leftJoin('dnm_cosmeticos_si.COS.profesionalesCosmeticos as pc','pc.idCosmetico','=','c.idCosmetico')
            ->select('c.idCosmetico',DB::raw("(CASE when c.tipo=1 then
                    'REGISTRO COSMÉTICO' else 'RECONOCIMIENTO COSMÉTICO' END) as tipo"),'c.nombreComercial',DB::raw("(CASE when c.estado='A' then
                    'ACTIVO' else 'INACTIVO' END) as estado"),'c.vigenciaHasta','pc.idPoder')
            ->distinct();
        return Datatables::of($cosmeticos)
            ->addColumn('opciones', function ($dt) {
                return '<a href="' . route('vercosmetico', ['idCosmetico' => Crypt::encrypt($dt->idCosmetico), 'opcion' => Crypt::encrypt(0)]) . '" class="btn btn-primary btn-sm"><b>VER</b></a> <a href="' . route('vercosmetico', ['idCosmetico' => Crypt::encrypt($dt->idCosmetico), 'opcion' => Crypt::encrypt(1)]) . '" class="btn btn-info btn-sm"><b>EDITAR</b></a> ';
            })
            ->filter(function($query) use ($request){
                if($request->has('ncosmetico'))
                    $query->where('c.idCosmetico',$request->get('ncosmetico'));

                if($request->has('nomComercial'))
                    $query->where('c.nombreComercial','like','%'.$request->get('nomComercial').'%');

                if($request->has('tipo'))
                    $query->where('tipo',$request->get('tipo'));

                if($request->has('titular'))
                    $query->where('c.idTitular',$request->get('titular'));

                if($request->has('profesional'))
                    $query->where('pc.idProfesional',$request->profesional);

                if($request->has('fabricante')){
                    $fab = FabricantesCosmeticos::where('idFabricante',$request->fabricante)->distinct()->pluck('idCosmetico');
                    $query->whereIn('c.idCosmetico', $fab);
                }

                if($request->has('idPais'))
                    $query->where('c.idPaisOrigen',$request->idPais);

            })->rawColumns(['opciones'])
            ->make(true);

    }

    public function getSustanciasCos()
    {
        $data = ['title' => 'Crear Sustancia para Producto de Cosmético',
            'subtitle' => ''];

        $sustancia = FormulaCosmeticos::getSustancias();
        return Datatables::of($sustancia)
            ->make(true);

    }

    public function guardarSustancia(Request $request)
    {
        //dd($request);
        $data = ['title' => 'Crear Sustancia para Productos de Cosméticos e Higiénicos',
            'subtitle' => ''];
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if ($request->tipo == 0) {
                $sustancia = new SustanciaHigienico();
                $sustancia->nombreSustancia = $request->nombre;
                $sustancia->numeroCAS = $request->cas;
                $sustancia->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                $sustancia->save();
            } else {
                $sustancia = new SustanciaCosmetico();
                $sustancia->denominacionINCI = $request->nombre;
                $sustancia->numeroCAS = $request->cas;
                $sustancia->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                $sustancia->save();
            }

            Session::flash('message', 'Se guardo sustancia correctamente');
        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return back();
            Session::flash('message', 'Ocurrio un error al guardar los datos');
        }
        DB::connection('sqlsrv')->commit();

        return view('sustancias.crearSustancia', $data);
    }

    public function verCosmetico($id, $opcion)
    {
        $data = ['title' => 'Catálogo de Cosméticos',
            'subtitle' => ''];
        $data['pro']=null;
        $data['pp'] = null;


        $id = Crypt::decrypt($id);
        $opcion = Crypt::decrypt($opcion);
        $paises = Solicitud::getPaisesCA();
        $allPaises = Pais::where('activo','A')->select('codigoId','nombre')->get();
        //--Busco las generales del producto--//
        $cosmetico = Cosmetico::find($id);


        $solicitud=Solicitud::where('idProducto',$id)->first();
        if(!empty($solicitud)) $data['solicitud']=$solicitud;


        $fragancias = Cosmetico::find($id)->fragancias;

        $tonos = Cosmetico::find($id)->tonos;

        $importadores = Cosmetico::getImportadores($id);

        $fabri = Cosmetico::existeFabri($id);
        if ((count($fabri)) > 0) {
            $fabricantes = Cosmetico::getFabricantes($id);
            $data['fab'] = $fabricantes;
        } else {
            $data['fab'] = 0;
        }
        $prof = $cosmetico->profesional;
        if (!empty($prof)) {
            if(!empty($prof->idProfesional) && !empty($prof->idPoder)){
                $profesional = Cosmetico::getProfesional($prof->idProfesional,$prof->idPoder);
                $data['pro'] = $profesional;
            }
        }
        $distribuidores = Cosmetico::getDistribuidoresCos($id);


        //--Busco el propietario con el idTItular--//
        if(!empty($cosmetico->tipoTitular) && !empty($cosmetico->idTitular)) {
            if ($cosmetico->tipoTitular != 3) {
                if (VwPropietario::find($cosmetico->idTitular) != null) {
                    $propietario = Propietario::getTitular($cosmetico->idTitular, $cosmetico->tipoTitular);
                    $data['pp'] = $propietario;
                }
            } else {
                if (Propietario::find($cosmetico->idTitular) != null) {
                    $propietario = Propietario::getTitular($cosmetico->idTitular, $cosmetico->tipoTitular,1);
                    $data['pp'] = $propietario;
                }
            }
        }
        //--Extraigo Formula--//
        $formula = $cosmetico->formula;
        //dd($cosmetico->formula);
        $array = [];

        if ($formula) {
            for ($i = 0; $i < count($formula); $i++) {
                $array[$i] = $cosmetico->formula->get($i)->sustancias()->first();
            }
            $sust = Collection::make($array);
            $data['sust'] = $sust;
            $data['formula'] = $formula;
            //dd($formula);
        }
        //--Extraigo presentaciones--//
        /* $pres=$cosmetico->presentaciones;
         //dd($pres);

         if(!$pres->isEmpty()){
             for($i=0; $i<count($pres); $i++){
                 $pres1[$i]=$cosmetico->presentaciones->get($i)->idPresentacion;
               }
             $idCoempaques=DetalleCoempaques::whereIn('idPresentacion',$pres1)->get()->pluck('idCoempaque')->toArray();
             $coempaques=Coempaques::getCoempaques($idCoempaques);
             $data['coempaques']=$coempaques;
             $data['detCoempaques']=$idCoempaques;
        }*/

        $pres = $cosmetico->presentaciones;

        if (count($pres) > 0) {
            for ($i = 0; $i < count($pres); $i++) {
                $pres1[$i] = $cosmetico->presentaciones->get($i)->idPresentacion;
            }
            //dd($producto);
            $idCoempaques = DetalleCoempaques::whereIn('idPresentacion', $pres1)->get()->pluck('idCoempaque')->toArray();

            $coempaques = Coempaques::getCoempaques($idCoempaques);
            //dd($coempaques);
            $detalles = [];
            for ($i = 0; $i < count($coempaques); $i++) {
                $detalles[$i] = Coempaques::getDetalle($coempaques[$i]->idCoempaque)->toArray();

            }
            $data['detalles'] = $detalles;
            $data['coempaques'] = $coempaques;
        }

        //dd(count($detalles));
        //--Extraigo tipo de producto--//
        if ($cosmetico->tipo == 1) {
            $cosmetico->tipoProducto = 'REGISTRO COSMÉTICO';
        } else {
            $cosmetico->tipoProducto = 'REGISTRO RECONOCIMIENTO COSMÉTICO';
        }
        if ($cosmetico->estado[0] == 'A') {
            $cosmetico->estado = 'ACTIVO';
        } else {
            $cosmetico->estado = 'INACTIVO';
        }
        //dd($cosmetico);

        $data['cos'] = $cosmetico;
        $data['clasificacionProd'] = 'COS'; // PARA SABER SI ES COS O HIG EN CONSULTAS
        $data['pais'] = $cosmetico->pais;
        $data['pres'] = $pres;
        $data['fra'] = $fragancias;
        $data['tonos'] = $tonos;
        $data['imp'] = $importadores;
        //dd($cosmetico->tipoProducto);

        $data['dis'] = $distribuidores;
        $data['paises'] = $paises;
        $data['allPaises'] =$allPaises;
        /*$poder = ProfesionalesPoderes::where('ID_PODER','DNM-651-PR-2015')->first();
        $prueba=$poder->getProfesionalPropietario($poder->ID_PROFESIONAL,$poder->ID_PROPIETARIO);
        dd($prueba[0]->NOMBRE_PROPIETARIO);*/

        //dd($data);
        if ($fragancias->isEmpty() || $tonos->isEmpty() || $pres->isEmpty() || $importadores->isEmpty() || $distribuidores->isEmpty() || empty($profesional)) {

            Session::flash('message', 'Este producto no posee registros');
        }

        //dd($data);

        if ($opcion == 0) {
            return view('Cosmeticos.detalleCosmetico', $data);
        }
        else if($opcion==1) {
            $areas = Area::all()->where('estado', 'A');
            $marcas = Marca::all()->where('estado', 'A');
            $data['marcas'] = $marcas;
            $data['areas'] = $areas;
        }
        //vista solo de tabs
        else if($opcion==2) {
            return view('Cosmeticos.tabsCosmeticos', $data);
        }

        return view('Cosmeticos.detalleCosmeticoEditar', $data);
    }


    public function getDetalleCoempaque(Request $request)
    {
        return Coempaques::getDetalle($request->id);
    }

    public function indexSustancias()
    {
        $data = ['title' => 'Catálogo de Sustancias para Productos Cosméticos',
            'subtitle' => ''];

        return view('sustancias.indexCos', $data);

    }

    public function crearSustancias()
    {
        $data = ['title' => 'Crear de Sustancias para Productos Cosméticos e Higiénicos',
            'subtitle' => ''];

        return view('sustancias.crearSustancia', $data);

    }


    public function editarClasificacion(Request $request)
    {
        // dd($request);
        $rules = ['area' => 'required',
            'class' => 'required',
            'forma' => 'required'];

        $message = ['area.required' => 'Debe seleccionar un área Válida',
            'class.required' => 'Debe seleccionar una clasificación Válida',
            'forma.required' => 'Debe seleccionar una Forma Cosmética Válida'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try {
            $cosmetico = Cosmetico::find($request->NoRegistro);
            $cosmetico->idClasificacion = $request->class;
            $cosmetico->idForma = $request->forma;
            $cosmetico->idUsuarioModificacion = Auth::user()->idUsuario . '@' . $request->ip();
            $cosmetico->save();
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Resultado con exito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado ese Registro Cosméticos!', 'data' => []]);
        }

    }

    public function editarGenerales(Request $request)
    {
        //dd($request);
        $messages = [
            'required' => 'Debe seleccionar un :attribute.'

        ];

        $rules = ['idCosmetico' => 'required',
            'nombreComercial' => 'required',
            'vigenciaHasta' => 'required',
            'renovacion' => 'required',
            'estado' => 'required',
            'actualizado' => 'required'
        ];

        $nombres = [
            'idCosmetico' => 'Número de Registro',
            'nombreComercial' => 'Nombre Comercial',
            'vigenciaHasta' => 'Fecha de Vigencia',
            'renovacion' => 'Fecha de Renovación',
            'estado' => 'Estado',
            'actualizado' => 'Actualizado'
        ];

        if ($request->idtipo == 2) {
            $rules += [
                'numeroReconocimiento' => 'required',
                'fechaVencimiento' => 'required'
            ];

            $nombres += [
                'numeroReconocimiento' => 'Número de Registro en País Origen',
                'fechaVencimiento' => 'Fecha de Vencimiento'

            ];
        }

        $validacion = Validator::make($request->all(), $rules, $messages);
        $validacion->setAttributeNames($nombres);

        if ($validacion->fails()) {
            $msg = "<ul>";
            foreach ($validacion->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 404, 'message' => $msg]);
        }
        //dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try {
            $cosmetico = Cosmetico::find($request->idCosmetico);
            if ($request->idtipo == 2) {
                $cosmetico->numeroReconocimiento = $request->numeroReconocimiento;
                $cosmetico->VencimientoRec = $request->fechaVencimiento;
                //$cosmetico->idPaisOrigen = $request->idPais;
            }
            $cosmetico->nombreComercial = $request->nombreComercial;
            $cosmetico->vigenciaHasta = date('Y-m-d', strtotime($request->vigenciaHasta));
            $cosmetico->idPaisOrigen = $request->idPais;
            $cosmetico->renovacion = date('Y-m-d', strtotime($request->renovacion));
            //Cambiando valores de actualización solo cuando se escoge desde el select
            if ($cosmetico->actualizado != $request->actualizado) {
                $cosmetico->actualizado = $request->actualizado;
                $cosmetico->fechaActualizado = Carbon::now('America/El_Salvador');
            }
            $cosmetico->idUsuarioModificacion = Auth::user()->idUsuario . '@' . $request->ip();
            $cosmetico->estado = $request->estado;
            $cosmetico->save();

            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }

    public function editarMarca(Request $request)
    {
        $rules = ['marca' => 'required'
        ];

        $message = ['marca.required' => 'Debe seleccionar una Marca Válida'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try {
            $cosmetico = Cosmetico::find($request->NoRegistro);
            $cosmetico->idMarca = $request->marca;
            $cosmetico->idUsuarioModificacion = Auth::user()->idUsuario . '@' . $request->ip();
            $cosmetico->save();

            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }


    }

    public function editarFormula(Request $request)
    {
        //  dd($request);
        $rules = ['idDenominacion' => 'required'
        ];

        $message = ['idDenominacion.required' => 'Debe seleccionar una sustancia para la formula'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try {

            DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.COS.formulaCosmetico where idCosmetico = ?', [$request->NoRegistro]);

            for ($i = 0; $i < count($request->idDenominacion); $i++) {
                $cosmeticoFormula = new FormulaCosmeticos();
                $cosmeticoFormula->idDenominacion = $request->idDenominacion[$i];
                $cosmeticoFormula->idCosmetico = $request->NoRegistro;
                $cosmeticoFormula->porcentaje = $request->porcentaje[$i];
                $cosmeticoFormula->idUsuarioCreacion = Auth::user()->idUsuario . '@' . $request->ip();
                $cosmeticoFormula->save();
            }
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }


    public function editarProfesional(Request $request)
    {
        // dd($request);
        $rules = ['idPoderprof' => 'required'
        ];

        $message = ['idPoderprof.required' => 'Debe seleccionar un Poder de Profesional'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try {
            DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.COS.profesionalesCosmeticos where idCosmetico = ?', [$request->NoRegistro]);

            $cosmeticoProf = new ProfesionalesCosmeticos();
            $cosmeticoProf->idCosmetico = $request->NoRegistro;
            $cosmeticoProf->idPoder = $request->idPoderprof;
            $cosmeticoProf->idProfesional = $request->idProfesional;
            $cosmeticoProf->idUsuarioCrea = Auth::user()->idUsuario . '@' . $request->ip();
            //$cosmetico->idUsuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
            $cosmeticoProf->save();

            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarPropietario(Request $request)
    {
        // dd($request);
        $rules = ['idTitular' => 'required'
        ];

        $message = ['idTitular.required' => 'Debe seleccionar un Propietario'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }

        DB::connection('sqlsrv')->beginTransaction();
        try {

            $cosmetico = Cosmetico::find($request->NoRegistro);
            $cosmetico->tipoTitular = $request->titularTipo;
            if ($request->titularTipo != 3)
                $cosmetico->idTitular = $request->nit;
            else
                $cosmetico->idTitular = $request->idTitular;
            $cosmetico->idUsuarioModificacion = Auth::user()->idUsuario . '@' . $request->ip();
            $cosmetico->save();

            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarTonos(Request $request)
    {

        $rules = ['tonos' => 'required'
        ];

        $message = ['tonos.required' => 'Debe seleccionar un Tonos'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
        // dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try {

            DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.COS.tonosCosmeticos where idCosmetico = ?', [$request->NoRegistro]);

            for ($i = 0; $i < count($request->tonos); $i++) {
                $cosmeticoTonos = new TonosCosmeticos();
                $cosmeticoTonos->idCosmetico = $request->NoRegistro;
                $cosmeticoTonos->tono = $request->tonos[$i];
                $cosmeticoTonos->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                $cosmeticoTonos->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarFragancias(Request $request)
    {


        $rules = ['fragancias' => 'required'];

        $message = ['fragancias.required' => 'Debe seleccionar al menos una Fragancia'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
        // dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try {

            DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.COS.fraganciasCosmeticos where idCosmetico = ?', [$request->NoRegistro]);

            for ($i = 0; $i < count($request->fragancias); $i++) {
                $cosmeticoFragancias = new FraganciasCosmeticos();
                $cosmeticoFragancias->idCosmetico = $request->NoRegistro;
                $cosmeticoFragancias->fragancia = $request->fragancias[$i];
                $cosmeticoFragancias->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                $cosmeticoFragancias->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }

    }

    public function editarFabricantes(Request $request)
    {
        //dd($request->all());

        $rules = ['fabricantes' => 'required'];

        $message = ['fabricantes.required' => 'Debe seleccionar al menos un fabricante'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
        // dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try {

            DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.COS.fabricantesCosmeticos where idCosmetico = ?', [$request->NoRegistro]);

            for ($i = 0; $i < count($request->fabricantes); $i++) {
                $cosmeticoFab = new FabricantesCosmeticos();
                $cosmeticoFab->idCosmetico = $request->NoRegistro;
                $cosmeticoFab->idFabricante = $request->fabricantes[$i];
                $cosmeticoFab->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                $cosmeticoFab->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }

    public function editarDistribuidores(Request $request)
    {

        $rules = ['poderDistribuidores' => 'sometimes'];

        $message = ['poderDistribuidores.sometimes' => 'Debe seleccionar al menos un Distribuidor'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
        //  dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try {

            $pro=Cosmetico::find($request->NoRegistro);
            $pro->distribuidores()->delete();
            if($request->has('poderDistribuidores')){
                    for ($i = 0; $i < count($request->poderDistribuidores); $i++) {
                            $cosmeticoFab = new DistribuidoresCosmeticos();
                            $cosmeticoFab->idCosmetico = $request->NoRegistro;
                            $cosmeticoFab->idPoder = $request->poderDistribuidores[$i];
                            $cosmeticoFab->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                            $cosmeticoFab->save();
                        }
            }
            if($request->has('disTitu')){
                $pro->distribuidorTitular=$request->disTitu;
                $pro->idUsuarioModificacion= Auth::User()->idUsuario . '@' . $request->ip();
                $pro->save();
            }
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }

    public function editarImportadores(Request $request)
    {
        $rules = ['importadores' => 'required'];

        $message = ['importadores.required' => 'Debe seleccionar al menos un Importador'];

        $validacion = Validator::make($request->all(), $rules, $message);
        if ($validacion->fails()) {
            return response()->json(['status' => 404, 'message' => 'Debe completar todos los campos!!', 'data' => []]);
        }
        //  dd($request);

        DB::connection('sqlsrv')->beginTransaction();
        try {

            DB::connection('sqlsrv')->delete('delete from dnm_cosmeticos_si.COS.importadoresCosmeticos where idCosmetico = ?', [$request->NoRegistro]);

            for ($i = 0; $i < count($request->importadores); $i++) {
                $cosmeticoImp = new ImportadoresCosmeticos();
                $cosmeticoImp->idCosmetico = $request->NoRegistro;
                $cosmeticoImp->idImportador = $request->importadores[$i];
                $cosmeticoImp->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
                $cosmeticoImp->save();
            }


            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se han actualizado los datos con éxito', 'data' => []]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error: no se ha encontrado el número de registro en la Base de datos!', 'data' => []]);
        }
    }


    public function savePresentacion(Request $request)
    {

        if ($request->clas == 1) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
            ];

            $v = Validator::make($request->all(), [
                'empaqueSec' => 'required',
                'materialSec' => 'required',
                'contenidoSec' => 'required'

            ], $messages);

            $v->setAttributeNames([
                'empaqueSec' => 'Empaque Secundario',
                'materialSec' => 'Material Secundario',
                'contenidoSec' => 'Contenido Secundario'
            ]);

        } else {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
            ];

            $v = Validator::make($request->all(), [
                'empaquePri' => 'required',
                'materialPri' => 'required',
                'contenidoPri' => 'required',
                'unidad' => 'required',
            ], $messages);

            $v->setAttributeNames([
                'empaquePri' => 'Empaque Primario (EP)',
                'materialPri' => 'Material Primario (MP)',
                'contenidoPri' => 'Contenido Primario',
                'unidad' => 'Medida',
            ]);

        }

        //Validaciones de sistema
        if ($v->fails()) {
            $msg = "<ul class='text-warning'>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 404, 'message' => 'Debe completar:', 'data' => ['message' => $msg]]);
        }
        // $request->idsolicitud='325';
        DB::connection('sqlsrv')->beginTransaction();
        try {
            $presentacion = new PresentacionesCosmeticos();
            $presentacion->idCosmetico = $request->idCosmetico;
            $presentacion->idEnvasePrimario = $request->empaquePri;
            $presentacion->idMaterialPrimario = $request->materialPri;
            $presentacion->contenidoPrimario = $request->contenidoPri;
            $presentacion->idUnidad = $request->unidad;
            if ($request->empaqueSec != '') {
                $presentacion->idEnvaseSecundario = $request->empaqueSec;
            }
            if ($request->materialSec != '') {
                $presentacion->idMaterialSecundario = $request->materialSec;
            }
            if ($request->contenidoSec != '') {
                $presentacion->contenidoSecundario = $request->contenidoSec;
            }
            if ($request->peso != '') {
                $presentacion->peso = $request->peso;
            }
            if ($request->medida != '') {
                $presentacion->idMedida = $request->medida;
            }
            if ($request->nombre != '') {
                $presentacion->nombrePresentacion = $request->nombre;
            }
            if ($request->texto != '') {
                $presentacion->textoPresentacion = $request->texto;
            }
            $presentacion->idUsuarioCrea = Auth::User()->idUsuario . '@' . $request->ip();
            $presentacion->save();

            $presentacionesCos = PresentacionesCosmeticos::getPresentacionesCos($request->idCosmetico);
            $presentacionesCos->total = count($presentacionesCos);
            //dd($presentacionesCos);
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200, 'message' => 'Se ingreso presentación correctamente!', 'data' => ['presentaciones' => $presentacionesCos]]);

        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            //  return $e->getMessage();
            return response()->json(['status' => 400, 'message' => 'Error: no pudimos guardar su presentación!', 'data' => []]);
            /*  throw $e;*/
        }

    }


    public function deletePresentacion(Request $request)
    {
        DB::connection('sqlsrv')->beginTransaction();
        try {
            $pres = PresentacionesCosmeticos::where('idPresentacion', $request->idPresentacion)->where('idCosmetico', $request->idCosmetico)->delete();
            if ($pres == 1) {
                DB::connection('sqlsrv')->commit();
                return response()->json(['status' => 200, 'message' => 'Se elimino presentación correctamente!', 'data' => []]);
            } else {
                return response()->json(['status' => 400, 'message' => 'Error: no pudimos elimiinar su presentación!', 'data' => []]);
            }
        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollback();
            throw $e;
            //  return $e->getMessage();
            return response()->json(['status' => 404, 'message' => 'Error: consulte con informatica!', 'data' => []]);
            /*  throw $e;*/
        }
    }

    public function getPresentacionesCosmeticos(Request $request)
    {
        $tipo = $request->tipo;
        $presentaciones = PresentacionesCosmeticos::getPresentacionesCos($request->idCos);

        return Datatables::of($presentaciones)
            ->addColumn('opciones', function ($dt) {
                return '<a class="btn btn-xs btn-danger borrarPres"><i class="fa fa-times" aria-hidden="true"></i></a>';

            })->rawColumns(['opciones'])
            ->make(true);

    }

}
