<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Material extends Model {

	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.CAT.materialesPresentaciones';
	protected $fillable = [];
	protected $primaryKey='idMaterial';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
	

	public static function getMateriales(){
		$items="<option></option>";

		$materiales=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.materialesPresentaciones')
		->select('idMaterial','material')
		->where('estado', 'A')->get();

		foreach($materiales as $m){
			$items.="<option value='".$m->idMaterial."'>".$m->material."</option>";
		}
		return $items;
	}
}