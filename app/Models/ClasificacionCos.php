<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClasificacionCos extends Model
{
     protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.clasificacion';
	protected $fillable = [];
	protected $primaryKey='idClasificacion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function area(){
		return $this->belongsTo('App\Models\Area', 'idArea', 'idAreaAplicacion');
	}

	public static function getClasificaciones(){
		return DB::connection('sqlsrv')
				->table('dnm_cosmeticos_si.COS.clasificacion')
				->select(DB::raw("idClasificacion, nombreClasificacion, (CASE when poseeFragancia=1 then 'SI' else 'NO' END) poseeFragancia,
					(CASE when poseeTono=1 then 'SI' else 'NO' END) poseeTono, (CASE when estado='A' then 'SI' else 'NO' END) estado"));

	}
   
   public static function consultar($id){
   	$inputs='';
   	$clas= DB::connection('sqlsrv')
				->table('dnm_cosmeticos_si.COS.clasificacion')
				->select('poseeTono','poseeFragancia')
				->where('idClasificacion',$id)->get();
	
	//$inputs.='<input type="hidden" value="'.$clas[0]->poseeTono.'" name="poseeT"><input type="hidden" value="'.$clas[0]->poseeFragancia.'" name="poseeF">';

	return $clas;
   }

   public static function getClassByArea($id){
		$items="";

		$clas= DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.clasificacion')
		->select('idClasificacion','nombreClasificacion')->where('estado','A')
		->where('idArea',$id)->get();
			$items.="<option></option>";
		foreach ($clas as $c) {
			$items .="<option value='".$c->idClasificacion."'>".$c->nombreClasificacion."</option>";
		}
		return $items;
		
	}

	public static function getClasificacionCos(){
		$items="";

		$clas= DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.clasificacion')
		->select('idClasificacion','nombreClasificacion')->where('estado','A')
		->get();
			$items.="<option></option>";
		foreach ($clas as $c) {
			$items .="<option value='".$c->idClasificacion."'>".$c->nombreClasificacion."</option>";
		}
		return $items;
		
	}

	
	
}
