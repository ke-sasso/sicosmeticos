<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Area extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.areasAplicacion';
	protected $fillable = [];
	protected $primaryKey='idAreaAplicacion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public function clasificaciones(){
		return $this->hasMany('App\Models\ClasificacionCos', 'idAreaAplicacion', 'idArea');
	}

	public static function getArea($id){

		return  DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.areasAplicacion')
				->where('idAreaAplicacion',$id)
				->select('nombreArea')->get();
					
	}
}
