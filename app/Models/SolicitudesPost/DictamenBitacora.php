<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class DictamenBitacora extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.dictamenBitacoraDoc';
    protected $primaryKey='idBitacora';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public function estado(){
        return $this->hasOne('App\Models\EstadoSolicitud','idEstado','idEstado');
    }

    public function detalles(){
        return $this->hasMany('App\Models\SolicitudesPost\DictamenDetalle','idDictamen','idDictamen');
    }

}
