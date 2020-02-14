<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class Marca extends Model {

	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.CAT.marcas';
	protected $fillable = [];
	protected $primaryKey='idMarca';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
	
	public function SolicitudesDetalles(){
		return $this->hasMany('App\Models\SolicitudesDetalle', 'idMarca', 'idMarca');
	}

	public static function getMarcas($nombre){
		  return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.marcas')
                 ->select('idMarca','nombreMarca')
                 ->where('nombreMarca','like','%'.$nombre.'%')
                 ->where('estado','A')->take(10)->get();
	}

}