<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class FabricantesCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.fabricantesCosmeticos';
	protected $fillable = [];
	protected $primaryKey='idCosmetico';
    public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	private $idFabricantes;

	public static function getIDFabricantes($idCos){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.fabricantesCosmeticos')
		->select('idFabricante')->where('idCosmetico',$idCos)->pluck('idFabricante');
	}

    public static function fabricantes($ids){
        $first = DB::table('dnm_catalogos.vwfabricantesextrajeros')->select('idFabricanteExtranjero as idFabricante','nombreFabricante','nombrePais as pais')
                    ->whereIn('idFabricanteExtranjero',$ids);

        $second = DB::table('dnm_establecimientos_si.vw_dnm_cssp_establecimientos')->select('idEstablecimiento as idFabricante','nombreComercial as nombreFabricante','pais')
                    ->union($first)
                    ->whereIn('idEstablecimiento',$ids)
                    ->get();
        //dd($second);
        if(!empty($second)){
            $fabricantes='';
            foreach ($second as $key=>$fb){
                //dd($fabricantes);
                //dd($fb->nombreFabricante);
                $fabricantes.=$fb->nombreFabricante.' ('.$fb->pais.')';
                if($key==(count($second)-1))
                    $fabricantes.='';
                else if($key==(count($second)-2))
                    $fabricantes.=' y ';
                else
                    $fabricantes.=', ';
            }
        }
        //dd($fabricantes);
        return $fabricantes;
    }


}