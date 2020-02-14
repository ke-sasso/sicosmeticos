<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleCoempaques extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.detalleCoempaques';
	protected $fillable = [];
	protected $primaryKey='idDetalleCoempaque';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function coempaque(){
		return $this->belongsTo('App\Models\Coempaques', 'idCoempaque', 'idCoempaque');
	}

	public function presentaciones(){
		return $this->hasMany('App\Models\Cosmeticos\PresentacionesCosmeticos', 'idPresentacion', 'idPresentacion');
	}

	public static function getDetCoempaque($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.detalleCoempaques as c')
		->join('dnm_cosmeticos_si.COS.coempaques as co','c.idCoempaque','co.idCoempaque')
		->join('dnm_cosmeticos_si.COS.presentacionesCosmeticos as p','c.idPresentacion','p.idPresentacion')	
		->select('c.idDetalleCoempaque','c.idCoempaque','c.idPresentacion','p.idCosmetico','p.textoPresentacion','co.nombreCoempaque')->where('c.idCoempaque',$id)->get();
	} 

	public static function getIdPres($id){

		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.presentacionesCosmeticos')
		->select('idPresentacion')
		->where('idCosmetico',$id)->get();
	}

	public static function getdetalle($ids)
	{
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.detalleCoempaques')
		->select('idCoempaque')
		->whereIn('idPresentacion',$ids)->distinct()->get();
	}


}
