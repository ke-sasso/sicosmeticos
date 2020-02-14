<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class Dictamen extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.dictamen';
    protected $primaryKey='idDictamen';
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

    public static function latestDictamenSolicitud($idSolicitud){
        return Dictamen::where('idSolicitud',$idSolicitud)->orderby('fechaCreacion','desc')->first();
    }

}
