<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Distribuidores extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.distribuidores';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function getDistribuidores($ids){
		return DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as dp')
				->join('cssp.cssp_establecimientos as e','dp.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
				->select('dp.ID_DISTRIBUIDOR_MAQUILA','e.NOMBRE_COMERCIAL')->whereIn('dp.ID_PODER',$ids)
				->get();

	
	}

	public static function getDistribuidoresSol($id){
		$ids=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.distribuidores as d')
            ->select('idPoderDistribuidor')
            ->where('idSolicitud',$id)
            ->pluck('idPoderDistribuidor');

		 return DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as d')
		 ->join('cssp.cssp_establecimientos as e','d.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
		->select('e.ID_ESTABLECIMIENTO as idEstablecimiento','e.NOMBRE_COMERCIAL as nombreDis','e.TELEFONO_1 as telefonosContacto', 'e.direccion','e.email as emailContacto','d.ID_PODER')
		->whereIn('d.ID_PODER',$ids)->get();
	}

	public static function distribuidoresConcat($ids){
	    $distribuidores = DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as dp')
            ->join('cssp.cssp_establecimientos as e','dp.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
            ->select('dp.ID_DISTRIBUIDOR_MAQUILA','e.NOMBRE_COMERCIAL')->whereIn('dp.ID_PODER',$ids)
            ->get();

        if(!empty($distribuidores)){
            $dists='';
            foreach ($distribuidores as $key=>$dt){
                $dists.=$dt->NOMBRE_COMERCIAL;
                if($key==(count($distribuidores)-1))
                    $dists.='';
                else if($key==(count($distribuidores)-2))
                    $dists.=' y ';
                else
                    $dists.=', ';
            }
        }
        //dd($dists);
        return $dists;
    }

}