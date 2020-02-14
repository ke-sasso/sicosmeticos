<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    //

    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.certificacion';
    protected $primaryKey='idCertificacion';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}
