<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class DistribuidoresCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.distribuidoresCosmeticos';
	protected $fillable = [];
	protected $primaryKey='idCosmetico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function getIDdistribuidores($idCos){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.distribuidoresCosmeticos')
		->select('idPoder')->where('idCosmetico',$idCos)->pluck('idPoder');
	}


}