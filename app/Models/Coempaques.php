<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Coempaques extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.coempaques';
	protected $fillable = [];
	protected $primaryKey='idCoempaque';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function getLastID(){
		$clCoemp = Coempaques::orderBy('idCoempaque', 'desc')->first();
		return $clCoemp->idCoempaque;
	}

	public function detalles(){
		return $this->hasMany('App\Models\DetalleCoempaques', 'idCoempaque', 'idCoempaque');
	}


	public static function getDetalle($ids){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.coempaques as cq')
		->join('dnm_cosmeticos_si.COS.detalleCoempaques as dc','cq.idCoempaque','dc.idCoempaque')
		->join('dnm_cosmeticos_si.COS.presentacionesCosmeticos as pc','pc.idPresentacion','dc.idPresentacion')
		->join('dnm_cosmeticos_si.COS.Cosmeticos as c','c.idCosmetico','pc.idCosmetico')
		->select('cq.nombreCoempaque','dc.idCoempaque','dc.idPresentacion','pc.textoPresentacion','c.idCosmetico',
	 			'c.nombreComercial')
		->where('cq.idCoempaque',$ids)->get();
	}

	public static function getCoempaques($ids){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.coempaques as cq')
		->select('idCoempaque','nombreCoempaque')
		->whereIn('cq.idCoempaque',$ids)->get(); 
	}
}
