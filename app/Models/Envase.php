<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Envase extends Model {

	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.CAT.envases';
	protected $fillable = [];
	protected $primaryKey='idEnvase';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
	

	public static function getEnvase($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.envases')
		->select('nombreEnvase','aplicaPara','estado','idUsuarioModificacion')
		->where('idEnvase', $id);
		
	}

	public static function updateEnvase($id, $envase){
		return DB::table('dnm_cosmeticos_si.CAT.envases');
	}

	public static function getEnvasesCosmeticos(){
		$items="<option></option>";

		$envases =DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.envases')
		->select('idEnvase','nombreEnvase')
		->whereIN('aplicaPara',['1','0'])
		->where('estado', 'A')->get();

		foreach ($envases as $e) {
			$items .="<option value='".$e->idEnvase."'>".$e->nombreEnvase."</option>";
		}
		return $items;
		
	}

}