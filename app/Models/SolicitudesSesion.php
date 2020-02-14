<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudesSesion extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SES.solicitudesSesion';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	

	public static function findSolicitud($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.solicitudesSesion')
		->where('idSolicitud',$id)->get();
	}

	public function solicitudPost(){
	    return $this->belongsTo('App\Models\SolicitudesPost\Solicitud','idSolicitud','idSolicitud');
    }
}