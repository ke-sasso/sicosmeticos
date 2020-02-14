<?php

namespace App\Models\Higienicos;

use Illuminate\Database\Eloquent\Model;
use DB;

class PresentacionesHigienicos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.presentacionesHigienicos';
	protected $fillable = [];
	protected $primaryKey='idHigienico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function getPresentacionesHigienicos(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.presentacionesHigienicos as ph')
		->join('dnm_cosmeticos_si.HIG.Higienicos as h','ph.idHigienico','h.idHigienico')
		->select('h.idHigienico as idProducto','h.nombreComercial','ph.idPresentacion','ph.textoPresentacion')
		->where('h.estado','A')
		->where('ph.estado','A')
		->get();
	}

	public static function getPresentacionesHig($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.presentacionesHigienicos as p')
	
		->select('p.idPresentacion','p.textoPresentacion')->where('p.idHigienico',$id)->orderBy('p.idPresentacion','DESC')->get();
	} 
}