<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.tramites';
    protected $primaryKey='idTramite';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    protected $hidden = ['usuarioCreacion','fechaCreacion','usuarioModificacion','fechaModificacion'];

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public function solicitud(){
        $this->belongsTo('App\Models\SolicitudesPost\Solicitud');
    }

    public static function getActivos(){
        return Tramite::where('activo','A')->orderby('nombreTramite')->get()->toArray();
    }

    public function requisitos(){
        return $this->belongsToMany('App\Models\SolicitudesPost\Requisito','dnm_cosmeticos_si.POST.tramiteRequisitos','idTramite','idRequisito')->withPivot('requerido');
    }
}
