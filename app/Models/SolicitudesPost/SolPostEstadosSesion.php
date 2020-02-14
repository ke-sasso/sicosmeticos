<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolPostEstadosSesion extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudEstadosSesion';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','idEstado','idDictamen','comentario','usuarioCreacion','usuarioModificacion'];
	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public static function latestEstadoSolicitud($idSolicitud){
    	return SolPostEstadosSesion::where('idSolicitud',$idSolicitud)->orderby('fechaCreacion','desc')->take(1)->get();
    }

}