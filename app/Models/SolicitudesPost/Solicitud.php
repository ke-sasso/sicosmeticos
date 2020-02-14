<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.solicitudes';
    protected $fillable = [];
    protected $primaryKey='idSolicitud';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public function estado(){
        return $this->hasOne('App\Models\EstadoSolicitud');
    }

    public function tramite(){
        return $this->hasOne('App\Models\SolicitudesPost\Tramite','idTramite','idTramite');
    }

    public function higienico(){
        return $this->hasOne('App\Models\Higienico','idHigienico','noRegistro');
    }

    public function cosmetico(){
        return $this->hasOne('App\Models\Cosmetico','idCosmetico','noRegistro');
    }

    public function documentos(){
        return $this->hasMany('App\Models\SolicitudesPost\SolicitudDocumento','idSolicitud','idSolicitud');
    }

    public function solicitante(){
        return $this->hasOne('App\Models\PersonaNatural','nitNatural','nitSolicitante');
    }

    public function dictamenes(){
        return $this->hasMany('App\Models\SolicitudesPost\Dictamen','idSolicitud','idSolicitud');
    }

    public function certificacion(){
        return $this->hasOne('App\Models\SolicitudesPost\Certificacion','idSolicitud','idSolicitud');
    }

    public function tono(){
        return $this->hasMany('App\Models\SolicitudesPost\SolTono','idSolicitud','idSolicitud');
    }

    public function fragancia(){
        return $this->hasMany('App\Models\SolicitudesPost\SolFragancia','idSolicitud','idSolicitud');
    }

    public function fechareconocimiento(){
        return $this->hasOne('App\Models\SolicitudesPost\SolFechaReconocimiento','idSolicitud','idSolicitud');
    }

    public function formula(){
        return $this->hasMany('App\Models\SolicitudesPost\SolFormula','idSolicitud','idSolicitud');
    }
     public function formulaDelete(){
        return $this->hasMany('App\Models\SolicitudesPost\FormulaDelete','idSolicitud','idSolicitud');
    }
    public function cambioNombre(){
        return $this->hasOne('App\Models\SolicitudesPost\SolNombreComercial','idSolicitud','idSolicitud');
    }
    public function presentaciones(){
        return $this->hasMany('App\Models\SolicitudesPost\SolPresentacion','idSolicitud','idSolicitud');
    }
    public function presentacionesDelete(){
        return $this->hasMany('App\Models\SolicitudesPost\PresentacionesDelete','idSolicitud','idSolicitud');
    }
    public function asignacion(){
        return $this->hasMany('App\Models\SolicitudesPost\AsignacionSolPost','idSolicitud','idSolicitud');
    }

    public static function verificarSolPost(){
        return Solicitud::where('idEstado','!=',10)->pluck('idMandamiento');
    }
    public function documentocertificacionFav(){
        //certificacion favorable
        return $this->hasOne('App\Models\SolicitudesPost\DocumentosCertificacion','idSolicitud','idSolicitud')->where('tipoDocumento',3)->where('estado','1');
    }
    public function documentocertificacionDesfav(){
        //certificacion desfavorable
        return $this->hasOne('App\Models\SolicitudesPost\DocumentosCertificacion','idSolicitud','idSolicitud')->where('tipoDocumento',5)->where('estado','1');
    }



}
