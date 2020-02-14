<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudesPresentaciones extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.presentaciones';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public static function getPresentacionesSol($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.presentaciones as p')
	
		->select('p.idPresentacion','p.textoPresentacion')->where('p.idSolicitud',$id)->orderBy('p.idPresentacion','DESC')->get();
	} 

	public static function actualizarPresentacion($idPre,$idCoempaque,$user){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.presentaciones')
		->where('idPresentacion',$idPre)
		->update(['idCoempaque'=>$idCoempaque],['idUsuarioModificacion'=>$user]);

	} 
}