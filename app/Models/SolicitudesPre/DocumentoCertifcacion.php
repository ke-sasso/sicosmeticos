<?php

namespace App\Models\SolicitudesPre;

use Illuminate\Database\Eloquent\Model;
use DB;

class DocumentoCertifcacion extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.documentoCertificacion';
	protected $primaryKey='idDocumento';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','urlArchivo','estado','tipoDocumento','usuarioCreacion','usuarioModificacion'];
	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
    public static function docCertificacionDesfavorable($idSolicitud){
    	return DocumentoCertifcacion::where('idSolicitud',$idSolicitud)->where('tipoDocumento',5)->where('estado',1)->first();
    }
     public static function docCertificacionFavorable($idSolicitud){
    	return DocumentoCertifcacion::where('idSolicitud',$idSolicitud)->where('tipoDocumento',3)->where('estado',1)->first();
    }

}