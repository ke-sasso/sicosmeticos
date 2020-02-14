<?php

namespace App\Models\SolicitudesPre;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolEstadosSesion extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.solicitudEstadosSesion';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','idEstado','idResolucionDictamen','comentario','usuarioCreacion','usuarioModificacion'];
	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public static function latestEstadoSolicitud($idSolicitud){
    	return SolEstadosSesion::where('idSolicitud',$idSolicitud)->orderby('fechaCreacion','desc')->take(1)->get();
    }

}