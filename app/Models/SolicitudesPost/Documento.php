<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.documentosSol';
    protected $primaryKey='idDocumento';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function solicitudDocumentos(){
        $this->hasOne('App\Models\SolicitudesPost\SolicitudDocumento','idDocumento','idDocumento');
    }
}
