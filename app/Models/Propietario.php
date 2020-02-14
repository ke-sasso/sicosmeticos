<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use GuzzleHttp\Client;
use Config;
use Log;
use Carbon\Carbon;

class Propietario extends Model
{

    protected $table = 'cssp.cssp_propietarios';
    protected $connection = 'mysql';
    protected $fillable = [];
    protected $primaryKey = 'id_propietario';

    public $incrementing = false;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    private $url = null;
    private $token = null;

    public function __construct()
    {
        $this->url = Config::get('app.api');
        $this->token = Config::get('app.token');
    }

    // protected $connection = 'sqlsrv';


    public static function getPropietarios($id)
    {
        return DB::connection('mysql')->table('cssp.cssp_propietarios as pp')
            ->leftJoin('dnm_catalogos.cat_paises as pais', 'pp.id_pais', '=', 'pais.idPais')
            ->select('pp.id_propietario', 'pp.nombre_propietario', 'pais.nombre', 'pp.direccion', 'pp.email', 'pp.telefono_1', DB::raw("CASE when pp.activo='A' then 
				 	'ACTIVO' else 'INACTIVO' END as estado"))
            ->where('pp.id_propietario', $id)->get();
    }

    public static function getPropietarioJuridico($nit)
    {
        $prop = DB::connection('mysql')->table('dnm_catalogos.dnm_persona_juridica as pj')
            ->join('dnm_catalogos.dnm_razones_sociales as rs', 'pj.nitJuridico', 'rs.nitJuridico')
            ->select('pj.nitJuridico as id_propietario', 'rs.nombreRazonSocial as nombre_propietario', 'pj.direccion', 'pj.emailContacto as email', DB::raw("replace(replace(pj.telefonosContacto,'{','['),'}',']') as telefono_1"), DB::raw("CASE when rs.vigente='A' then 
                    'ACTIVO' else 'INACTIVO' END as estado"))
            ->where('pj.nitJuridico', $nit)->get();
        $prop[0]->telefono_1 = str_replace('{', '', $prop[0]->telefono_1);
        $prop[0]->telefono_1 = str_replace('}', '', $prop[0]->telefono_1);
        $prop[0]->telefono_1 = str_replace('"telefono1":', '', $prop[0]->telefono_1);
        $prop[0]->telefono_1 = str_replace('"telefono2":', '', $prop[0]->telefono_1);
        return $prop;
    }

    public static function getTitular($idTitular, $tipoTitular,$opcion=null)
    {

        try {

            if ($tipoTitular == 1) {

                $propietario = VwPropietario::findOrFail($idTitular, array('nit', 'numeroDocumento', 'nombre', 'tipoPersona', 'direccion', 'telefonosContacto', 'emailsContacto'));
                $propietario->idPropietario = $propietario->nit;
                $propietario->PAIS = 'EL SALVADOR';
                $propietario->tipoTitular = 1;
            } elseif ($tipoTitular == 2) {

                $propietario = VwPropietario::findOrFail($idTitular, array('nit', 'nombre', 'tipoPersona', 'direccion', 'telefonosContacto', 'emailsContacto'));
                $propietario->idPropietario = $propietario->nit;
                $propietario->PAIS = 'EL SALVADOR';
                $propietario->tipoTitular = 2;
            } elseif ($tipoTitular == 3) {
                $propietario = Propietario::where(function($query) use ($opcion){
                                if($opcion!=null)$query->whereIn('cssp.cssp_propietarios.ACTIVO',['I','A']);
                                else $query->where('cssp.cssp_propietarios.ACTIVO','A');
                        })->where('ID_PROPIETARIO', $idTitular)
                            ->join('cssp.cssp_paises as pais', 'cssp.cssp_propietarios.id_pais', '=', 'pais.id_pais')
                            ->select('ID_PROPIETARIO as idPropietario', 'NOMBRE_PROPIETARIO as nombre', DB::raw("CONCAT('[\"',TELEFONO_1,'\",\"',TELEFONO_2,'\"]') as telefonosContacto"), 'DIRECCION as direccion', 'EMAIL as emailsContacto', 'pais.ID_PAIS', 'pais.NOMBRE_PAIS','cssp.cssp_propietarios.ACTIVO')
                            ->first();


                if (!empty($propietario)) {
                    $propietario->tipoPersona = 'E';
                    $propietario->PAIS = $propietario->NOMBRE_PAIS;
                    $propietario->tipoTitular = 3;
                }

            }
            return $propietario;
        } catch (\Exception $e) {
            //throw $e;
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);

        }
    }

    public static function getTitulares($tipoTitular)
    {
        //Tipo titular 1 y 2 es Nacional Natural y Juridico
        if ($tipoTitular == 1 || $tipoTitular == 2) {

            return DB::connection('mysql')->table('dnm_catalogos.vwpropietarios as prop')
                ->where(function ($query) use($tipoTitular) {
                    if($tipoTitular==1){
                        $query->where('prop.tipoPersona','=','N')->where('prop.numeroDocumento','<>','');
                    }
                    elseif($tipoTitular==2){
                        $query->where('prop.tipoPersona','=','J')->where('prop.nit','<>','');
                    }

                })
                ->select('prop.nit AS ID_PROPIETARIO','prop.nit as NIT','prop.nombre as NOMBRE_PROPIETARIO')
                ->get();
            /*
            return DB::table('cssp.cssp_propietarios as prop')
                ->join('dnm_catalogos.vwpropietarios as wp', function ($join) use ($tipoTitular) {
                    if ($tipoTitular == 1) {
                        $join->on('prop.NIT', '=', 'wp.nit')->where('wp.tipoPersona', '=', 'N')->where('prop.DUI', '<>', '');
                    } elseif ($tipoTitular == 2) {
                        $join->on('prop.NIT', '=', 'wp.nit')->where('wp.tipoPersona', '=', 'J');
                    }
                })
                ->where('prop.ID_PAIS', 2)
                ->where('prop.ACTIVO', 'A')
                ->select('prop.ID_PROPIETARIO', 'prop.NIT', 'prop.NOMBRE_PROPIETARIO')->get();
            */
        } //Tipo titular extranjero
        else {
            return Propietario::where('ID_PAIS', '<>', 2)->where('ACTIVO', 'A')
                ->select('ID_PROPIETARIO', 'NIT', 'NOMBRE_PROPIETARIO')->get();
        }
    }

}