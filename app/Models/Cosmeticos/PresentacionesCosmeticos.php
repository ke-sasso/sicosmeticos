<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class PresentacionesCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.presentacionesCosmeticos';
	protected $fillable = [];
	protected $primaryKey='idCosmetico';
	 public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function cosmetico(){
		return $this->belongsTo('App\Models\Cosmetico', 'idCosmetico', 'idCosmetico');
	}

	public function detallesCoempaque(){
		return $this->hasMany('App\Models\DetalleCoempaques', 'idPresentacion', 'idPresentacion');
	}

	public static function getPresentacionesCosmeticos(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.presentacionesCosmeticos as pc')
		->join('dnm_cosmeticos_si.COS.Cosmeticos as c','pc.idCosmetico','c.idCosmetico')
		->select('c.idCosmetico as idProducto','c.nombreComercial','pc.idPresentacion','pc.textoPresentacion')
		->where('c.estado','A')
		->where('pc.estado','A')
		->get();

	}

	public static function getPresentacionesCos($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.presentacionesCosmeticos as p')
	
		->select('p.idPresentacion','p.textoPresentacion')->where('p.idCosmetico',$id)->orderBy('p.idPresentacion','DESC')->get();
	} 


}