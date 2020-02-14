<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClasificacionHig extends Model
{
     protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.clasificacion';
	protected $fillable = [];
	protected $primaryKey='idClasificacion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public static function consultar($id){

   	$clas= DB::connection('sqlsrv')
				->table('dnm_cosmeticos_si.HIG.clasificacion')
				->select('poseeTono','poseeFragancia')
				->where('idClasificacion',$id)->get();
	
	
	return $clas;
   }

   public static function getClasHigienicos(){
   	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.clasificacion')
   				->select(DB::raw("idClasificacion, nombreClasificacion, (CASE when poseeFragancia=1 then 'SI' else 'NO' END) poseeFragancia,
					(CASE when poseeTono=1 then 'SI' else 'NO' END) poseeTono, (CASE when estado='A' then 'ACTIVO' else 'INACTIVO' END) estado"));
	}

	public static function getClasificacionHig(){
		$items="";
		$class=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.clasificacion')
		->select('idClasificacion','nombreClasificacion', 'poseeFragancia', 'poseeTono')->where('estado','A')->get();
		$items.="<option></option>";
		foreach ($class as $c ) {
			$items.="<option value='".$c->idClasificacion."'>".$c->nombreClasificacion."</option>";
		}
		return $items;
	}

	public static function getClasificacionesHig($nombre){
		  return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.clasificacion')
                 ->select('idClasificacion','nombreClasificacion')
                 ->where('nombreClasificacion','like','%'.$nombre.'%')
                 ->where('estado','A')->take(10)->get();
	}

	public static function getClasHig(){
	
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.clasificacion')
		->select('idClasificacion','nombreClasificacion', 'poseeFragancia', 'poseeTono')->where('estado','A')->get();		
	}

}