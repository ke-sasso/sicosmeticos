<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Resolucion extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.DIC.dictamenResolucion';
	protected $fillable = [];
	protected $primaryKey='idResolucion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public static function getResolucion($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenResolucion as dr')
			->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as est','est.idEstado','dr.resolucion')
		->select('dr.idResolucion','est.estado as resolucion','observacion','idUsuarioCrea','fechaCreacion')->where('idDictamen',$id)->get();
	}

	public static function getDicFavorable($ids)
	{
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenResolucion')
			->select('idDictamen')
			->whereIn('idDictamen',$ids)
			->where('resolucion',3)->get();
	}
}