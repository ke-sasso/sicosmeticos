<?php
/**
 * Created by PhpStorm.
 * User: steven.mena
 * Date: 20/2/2018
 * Time: 3:09 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Validator;
use Log;
use Carbon\Carbon;
use Config;
use App\Models\Propietario;
use App\Models\Profesional;
use App\Models\Marca;
use Yajra\Datatables\Datatables;
use App\Models\ProfesionalesPoderes;
use App\Models\Solicitud;
use App\Models\ClasificacionHig;
use DB;


class ToolsController extends Controller
{
    //
    private $url = null;
    private $token = null;

    public function __construct()
    {
        $this->url = Config::get('app.api');
        $this->token = Config::get('app.token');
    }



    /*public function searchTitular(Request $rq){

        $tipoTitular=$rq->tipoTitular;
        $querySearch=$rq->q;
        if($tipoTitular==1 || $tipoTitular==2)
                {
                   $r= DB::table('dnm_catalogos.vwpropietarios as prop')
                                ->where(function ($query) use($tipoTitular) {
                                    if($tipoTitular==1){
                                        $query->where('prop.tipoPersona','=','N')->where('prop.numeroDocumento','<>','');
                                    }
                                    elseif($tipoTitular==2){
                                        $query->where('prop.tipoPersona','=','J')->where('prop.nit','<>','');
                                    }

                                })
                                ->where(function($query) use ($querySearch){
                                    $query->where('prop.nombre','LIKE','%'.$querySearch.'%')->orWhere('prop.nit','LIKE','%'.$querySearch.'%');
                                })
                                ->select('prop.nit AS ID_PROPIETARIO','prop.nit as NIT','prop.nombre as NOMBRE_PROPIETARIO')->take(50)
                                ->get();
                }
                else
                {
                      /*return  DB::table('cssp.cssp_propietarios as prop')->join('cssp.siic_cosmeticos as cos','cos.ID_PROPIETARIO','=','prop.ID_PROPIETARIO')
                            ->join('cssp.cssp_paises as pa','pa.ID_PAIS','=','prop.ID_PAIS')->where('cos.ACTIVO','A')->where('pa.codigo','!=',222)
                            ->where(function($query) use ($querySearch){
                                $query->where('prop.NOMBRE_PROPIETARIO','LIKE','%'.$querySearch.'%')->orWhere('prop.ID_PROPIETARIO','LIKE','%'.$querySearch.'%');
                            })
                            ->groupBy('prop.ID_PROPIETARIO')->select('prop.ID_PROPIETARIO','prop.NIT','prop.NOMBRE_PROPIETARIO')->take(50)->get();*/
    /*  $r =  Propietario::where('ACTIVO','A')
          ->where(function($query) use ($querySearch){
              $query->where('NOMBRE_PROPIETARIO','LIKE','%'.$querySearch.'%')->orWhere('ID_PROPIETARIO','LIKE','%'.$querySearch.'%');
          })
          ->select('ID_PROPIETARIO','NIT','NOMBRE_PROPIETARIO')->take(50)->get();

  }

if ($r!=null) {
return response()->json(['status' => 200, 'data' => $r], 200);

}

}*/

    public function searchTitular(Request $rq)
    {

        $rules = [
            'q' => 'required',
            'tipoTitular' => 'required',
        ];

        $v = Validator::make($rq->all(), $rules);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }

        try {


            if ($rq->has('q')) {
                $query = $rq->q;
            }

            $client = new Client();
            $res = $client->request('POST', $this->url . 'pel/tools/search/titular', [
                'headers' => [
                    'tk' => $this->token,

                ],
                'form_params' => [
                    'nitOrNom' => $query,
                    'tipoTitular' => $rq->tipoTitular,
                    'idUnidad' => 'COS'
                ]
            ]);

            $r = json_decode($res->getBody());

            if ($r->status == 200) {
                return response()->json(['status' => 200, 'data' => $r->data], 200);

            } else if ($r->status == 400) {
                return response()->json(['status' => 400, 'message' => $r->message], 200);
            } else if ($r->status == 404) {
                return response()->json(['status' => 404, 'message' => $r->message], 200);
            }
        } catch (\Exception $e) {
            throw $e;
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return new JsonResponse([
                'message' => 'Error, favor contacte a DNM informática'
            ], 500);
        }
    }

    public function getTitular(Request $rq)
    {

        $rules = [
            'nitOrPp' => 'required',
            'tipoTitular' => 'required'

        ];

        $v = Validator::make($rq->all(), $rules);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }

        try {

            $client = new Client();
            $res = $client->request('POST', $this->url . 'pel/tools/get/titular', [
                'headers' => [
                    'tk' => $this->token,

                ],
                'form_params' => [
                    'nitOrPp' => $rq->nitOrPp,
                    'tipoTitular' => $rq->tipoTitular,
                    'idUnidad' => 'COS']
            ]);

            $r = json_decode($res->getBody());
            //dd($r->data);

            if ($r->status == 200) {
                return new JsonResponse([
                    'status' => 200,
                    'data' => $r->data
                ], 200);

            } else if ($r->status == 400) {
                return new JsonResponse([
                    'status' => 400,
                    'message' => $r->message
                ], 200);

            } else if ($r->status == 404) {
                //dd($r);
                return new JsonResponse([
                    'status' => 404,
                    'message' => $r->message
                ], 200);
            }
        } catch (\Exception $e) {
            throw $e;
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return new JsonResponse([
                'message' => 'Error, favor contacte a DNM informática'
            ], 500);
        }
    }

    public function getProfesionalByPoder(Request $rq)
    {

        $rules = [
            'poder' => 'required'

        ];

        $v = Validator::make($rq->all(), $rules);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }

        try {

            $poder = ProfesionalesPoderes::where('ID_PODER', $rq->poder)->first();

            if (empty($poder)) {
                return response()->json(['status' => 404, 'message' => "El numero de poder no es existe!"], 200);
            }
            $profesional = $poder->getProfesionalPropietario($poder->ID_PROFESIONAL, $poder->ID_PROPIETARIO);


            if (empty($profesional[0])) {
                return response()->json(['status' => 404, 'message' => "No se han encontrado el profesional!"], 200);
            } else {
                return response()->json(['status' => 200, 'data' => $profesional[0]], 200);
            }
        } catch (\Exception $e) {
            //throw $e;
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return new JsonResponse([
                'message' => 'Error, favor contacte a DNM informática',
                'data' => $e
            ], 500);
        }
    }

    public function searchFabOrImp(Request $rq)
    {

        $rules = [
            'q' => 'sometimes',
            'origenFab' => 'required',
        ];

        $v = Validator::make($rq->all(), $rules);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }

        try {

            $query = 'null';

            if ($rq->has('q')) {
                $query = $rq->q;
            }

            $client = new Client();
            $res = $client->request('POST', $this->url . 'pel/tools/search/fabOrImp', [
                'headers' => [
                    'tk' => $this->token,

                ],
                'form_params' => [
                    'fabOrImp' => $query,
                    'tipoEst' => $rq->origenFab
                ]
            ]);

            $r = json_decode($res->getBody());

            if ($r->status == 200) {
                return response()->json(['status' => 200, 'data' => $r->data], 200);

            } else if ($r->status == 400) {
                return response()->json(['status' => 400, 'message' => $r->message], 200);
            } else if ($r->status == 404) {
                return response()->json(['status' => 404, 'message' => $r->message], 200);
            }
        } catch (\Exception $e) {
            throw $e;
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return new JsonResponse([
                'message' => 'Error, favor contacte a DNM informática'
            ], 500);
        }
    }

    public function searchDistribuidor(Request $rq)
    {

        $rules = [
            'q' => 'sometimes'
        ];

        $v = Validator::make($rq->all(), $rules);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 400);
        }

        try {

            $query = 'null';

            if ($rq->has('q')) {
                $query = $rq->q;
            }

            $client = new Client();
            $res = $client->request('POST', $this->url . 'pel/tools/search/distribuidor', [
                'headers' => [
                    'tk' => $this->token,

                ],
                'form_params' => [
                    'nomDist' => $query
                ]
            ]);

            $r = json_decode($res->getBody());

            if ($r->status == 200) {
                return response()->json(['status' => 200, 'data' => $r->data], 200);

            } else if ($r->status == 400) {
                return response()->json(['status' => 400, 'message' => $r->message], 200);
            } else if ($r->status == 404) {
                return response()->json(['status' => 404, 'message' => $r->message], 200);
            }
        } catch (\Exception $e) {
            throw $e;
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return new JsonResponse([
                'message' => 'Error, favor contacte a DNM informática'
            ], 500);
        }
    }

    public function getPaisesSelect(Request $request)
    {
        $query = e($request->q);

        if (!$query && $query == '')
            return response()->json(array(), 400);

        $data = Pais::getContenidosPres($query);

        return response()->json(array(
            'data' => $data
        ));
    }

    public static function buscarPropietarios(Request $request)
    {
        $tipoTitular = $request->tipo;

        $titular = Propietario::getTitulares($tipoTitular);

        if ($tipoTitular != 3) {

            return Datatables::of($titular)
                ->addColumn('opciones', function ($dt) {
                    return '<button class="btn btn-xs btn-success prop" data-dismiss="modal" data-id="' . $dt->NIT . '" ><i class="fa fa-plus" id="buscarPropietario" aria-hidden="true"></i></button>';

                })->rawColumns(['opciones'])
                ->make(true);
        } else {
            return Datatables::of($titular)
                ->addColumn('opciones', function ($dt) {
                    return '<button class="btn btn-xs btn-success prop" data-dismiss="modal" data-id="' . $dt->ID_PROPIETARIO . '" ><i class="fa fa-plus" id="buscarPropietario" aria-hidden="true"></i></button>';
                })->rawColumns(['opciones'])
                ->make(true);
        }
    }

    public function buscarMarcas(Request $request)
    {
        $query = e($request->q);                                            //nombre para buscar

        if (!$query && $query == '')
            return response()->json(array(), 400);

        $data = Marca::getMarcas($query);

        return response()->json(array(
            'data' => $data
        ));
    }

    public function buscarClasificaciones(Request $request)
    {
        $query = e($request->q);                                            //nombre para buscar

        if (!$query && $query == '')
            return response()->json(array(), 400);

        $data = ClasificacionHig::getClasificacionesHig($query);

        return response()->json(array(
            'data' => $data
        ));
    }

    public function buscarProfesionalga(Request $request)
    {
        return Profesional::find($request->idPoder);
    }

    /**
     * buscarFabricantes (Selectize)
     * Devuelve un array json con el listado de fabricantes
     * autorizados para elaboración de productos Cosméticos e Higiénicos
     * según el criterio de búsqueda
     *
     * @param      \Illuminate\Http\Request  $request  Parámetros provenientes del GET
     *
     * @return     JSON                    Array json con listado de fabricantes
     */
    public function buscarFabricantes(Request $request)
    {

        // Criterio de búsqueda ingresado
        $query = e($request->q);
        $data = [];
        // Se devuelve array vacio en caso que el query no contenga valor
        if (!$query && $query == '') return response()->json(array(), 400);

        //Se valida el origen seleccionado para el fabricante
        switch ($request->o) {
            case 1: // Origen Nacional
                    //Se utiliza el curly syntax para elegir el tipo de función dependiendo si es Cosmético o Higiénico
                    //concatenando el parámetro t (tipo) proveniente de la consulta
                    $data = Solicitud::{'getFabricantesNacionales'.$request->t}($query); // 1=Nacionales

                break;
            case 2: // Origen del Fabricante Extranjero

                    $data = Solicitud::getFabricantesExtranjeros($query); // 2=Extranjero

                break;
        }

        return response()->json(array(
            'data' => $data
        ));
    }

    public function getFabricante(Request $request)
    {

        if ($request->origen == 1)
            $fabricante = Solicitud::getEstablecimiento($request->id); //busco el fabricante Nacional en los establecimiento registrados DNM_ESTA
        else
            $fabricante = Solicitud::getEstablecimientoExtranjero($request->id); //busco el fabricante Extranjero en los establecimiento registrados CSSP


        return $fabricante;
    }

    public function buscarDistribuidores(Request $request)
    {                       //búsqueda distribuidores selectize
        $query = e($request->q);

        if (!$query && $query == '') return response()->json(array(), 400);

        $data = Solicitud::getDistribuidores($query);

        return response()->json(array(
            'data' => $data
        ));

    }


    public function buscarDistribuidor(Request $request)
    {

        return Solicitud::getDistribuidorByPoder($request->poder);

    }

    public function buscarImportadores(Request $request)
    {

        $query = e($request->q);                                            //nombre para buscar
        //   dd($request->q);
        if (!$query && $query == '') return response()->json(array(), 400);

        $data = Solicitud::getImportadores($query); // Importadores son los establecimientos registrados

        return response()->json(array(
            'data' => $data
        ));
    }

    public function getImportador(Request $request)
    {
        return $fabricante = Solicitud::getEstablecimiento($request->id); //busco el importador en los establecimiento registrados
    }

    public function consultarMandamiento(){

        $data = ['title' => 'Consulta de Mandamientos', 'subtitle' => ''];

        return view('mandamientos.consultaMandamiento', $data);
    }

    public function getEvansesPost(){

        try {
            $client = new Client();
            $res = $client->request('POST', $this->url . 'pelcos/get/envanse', [
                'headers' => [
                    'tk' => $this->token,
                ]
            ]);

            $r = json_decode($res->getBody());

            if ($r->status == 200) {
                $items="";
                foreach ($r->data as $data) {
                    $items .="<option value='".$data->idEnvase."'>".htmlentities(trim($data->nombreEnvase))."</option>";
                }
                return response()->json(['status' => 200, 'data' => $items], 200);

            }
            else if ($r->status == 400){
                return response()->json(['status' => 400, 'message' => $r->message],200);
            }
        }
        catch (\Exception $e){
           // throw $e;
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }
        public function getMateriales(){

        try {
            $client = new Client();
            $res = $client->request('POST', $this->url . 'pelcos/get/materiales/presentaciones', [
                'headers' => [
                    'tk' => $this->token,
                ]
            ]);

            $r = json_decode($res->getBody());

            if ($r->status == 200) {
                $items="";
                foreach ($r->data as $data) {
                    $items .="<option value='".$data->idMaterial."'>".htmlentities(trim($data->material))."</option>";
                }
                return response()->json(['status' => 200, 'data' => $items], 200);

            }
            else if ($r->status == 400){
                return response()->json(['status' => 400, 'message' => $r->message],200);
            }
        }
        catch (\Exception $e){
            //throw $e;
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }

    public function getUnidadesMedida(){

        try {
            $client = new Client();
            $res = $client->request('POST', $this->url . 'pelcos/get/medidas', [
                'headers' => [
                    'tk' => $this->token,
                ]
            ]);

            $r = json_decode($res->getBody());

            if ($r->status == 200) {
                $items="";
                foreach ($r->data as $data) {
                    $items .="<option value='".$data->idMedida."'>".htmlentities(trim($data->abreviatura))."</option>";
                }
                return response()->json(['status' => 200, 'data' => $items], 200);

            }
            else if ($r->status == 400){
                return response()->json(['status' => 400, 'message' => $r->message],200);
            }
        }
        catch (\Exception $e){
            //throw $e;
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }


}
