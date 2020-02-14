<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class DocumentosCertificacion extends Model
{
    //

    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.certificacionDocumentos';
    protected $primaryKey='idDocumento';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    protected $fillable = ['idSolicitud','urlArchivo','estado','tipoDocumento','usuarioCreacion','usuarioModificacion'];

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}
