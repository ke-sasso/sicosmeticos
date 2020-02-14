<?php

namespace App\Models\SolicitudesPost;
use App\Models\SolicitudesPost\Documento;
use Illuminate\Database\Eloquent\Model;

class SolicitudDocumento extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.solicitudDocumentos';
    protected $primaryKey = 'idSolDoc';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function documento(){
        return $this->hasOne('App\Models\SolicitudesPost\Documento','idDocumento','idDocumento');
    }

    public static function getDocumento($idSol,$idReq){
        $sol=SolicitudDocumento::where('idSolicitud',$idSol)->where('idRequisito',$idReq)->first();
        if($sol){
            return Documento::where('idDocumento',$sol->idDocumento)->first();
        }
        return null;
    }

}
