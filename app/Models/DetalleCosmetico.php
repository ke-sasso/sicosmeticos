<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleCosmetico extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.detalleCosmetico';
	protected $primaryKey='idDetalle';
	protected $fillable = [];
	CONST CREATED_AT = 'fechaCreacion';
	CONST UPDATED_AT = 'fechaModificacion';


	//public $timestamps = false;

	public function detalle(){
		return $this->belongsTo('App\Models\SolicitudesDetalle', 'idDetalle', 'id');
	}

	public function clasificacion(){
		return $this->belongsTo('App\Models\ClasificacionCos', 'idClasificacion', 'idClasificacion');
	}

	public function forma(){
		return $this->belongsTo('App\Models\FormasCosmeticas', 'idFormaCosmetica', 'idForma');
	}

	public static function getDetalleC($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.detalleCosmetico as dc')
		->leftJoin('dnm_cosmeticos_si.COS.clasificacion as class','dc.idClasificacion','class.idClasificacion')
		->leftJoin('dnm_cosmeticos_si.COS.areasAplicacion as a','class.idArea','a.idAreaAplicacion')
		->leftJoin('dnm_cosmeticos_si.COS.formaCosmetica as fc','fc.idForma','dc.idFormaCosmetica')
		->select('dc.*','class.nombreClasificacion','a.nombreArea','fc.nombreForma')->where('idDetalle',$id)->get();
	}


}