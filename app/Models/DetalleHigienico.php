<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleHigienico extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.detalleHigienico';
	protected $fillable = [];
	protected $primaryKey='idDetalle';
	CONST CREATED_AT = 'fechaCreacion';
	CONST UPDATED_AT = 'fechaModificacion';

	//public $timestamps = false;

	public function detalle(){
		return $this->belongsTo('App\Models\SolicitudesDetalle', 'idDetalle', 'id');
	}

	public function clasificacion(){
		return $this->belongsTo('App\Models\ClasificacionHig', 'idClasificacion', 'idClasificacion');
	}

	public static function getDetalleH($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.detalleHigienico as dh')
		->leftJoin('dnm_cosmeticos_si.HIG.clasificacion as class','dh.idClasificacion','class.idClasificacion')
		->select('dh.*','class.nombreClasificacion')->where('idDetalle',$id)->get();
	}


}