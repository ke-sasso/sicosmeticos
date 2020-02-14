<?php

namespace App\Models\Cat;

use Illuminate\Database\Eloquent\Model;

class ArchivoExpediente extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.CAT.archivosExpediente';

    protected $primaryKey='idArchivoExp';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    protected $fillable = ['urlArchivo','tipoArchivo','usuarioCreacion','usuarioModificacion'];

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}
