<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Fabricantes extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.fabricantes';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function getFabricantes($ids){		 

		return DB::connection('mysql')->table('dnm_catalogos.fabricantesjoin')->select(DB::Raw('distinct *'))->whereIn('idEstablecimiento',$ids)->get();
	}
}