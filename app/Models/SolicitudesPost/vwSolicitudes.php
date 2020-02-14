<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

use App\Models\Sesion;

use App\Models\SolicitudesSesion;

class vwSolicitudes extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.vwSolicitudes';
    protected $primaryKey='idSolicitud';
    public $timestamps=false;
    public $incrementing= false;



    public static function sinCertificar(){
        return vwSolicitudes::where('idEstado','<>',9);
    }
    public static function getadministrador(){
        return vwSolicitudes::where('idEstado','<>',9);
    }

    public static function certificadas(){
        return vwSolicitudes::whereIn('idEstado',[9,3])->where('sesion',0);
    }

    public static function getIdsSolCertificadas(){
        return vwSolicitudes::where('idEstado',9)->pluck('idSolicitud');
    }

    public static function favParaSesion($idSesion){
        $sesion=Sesion::findOrFail($idSesion);

        return vwSolicitudes::whereIn('idEstado',[3])->where('sesion',1)
               ->whereDate('fechaCreacion','<',date('d/m/Y',strtotime($sesion->fechaSesion)))->get();
    }
    public static function agregadasEnSesion($idSesion){
        $solicitudes=SolicitudesSesion::where('idSesion',$idSesion)->where('tipoSolicitud',2)->pluck('idSolicitud')->toArray();

        return vwSolicitudes::whereIn('idSolicitud',$solicitudes)->get();
    }

    public static function aCertificar($idSesion){
        $sesion=Sesion::findOrFail($idSesion);

        return $sesion->solicitudesPostCertificar;
    }

    public static function getSolicitudAsignar(){
        return vwSolicitudes::whereIn('dnm_cosmeticos_si.POST.vwSolicitudes.idEstado',[1,2])->select('dnm_cosmeticos_si.POST.vwSolicitudes.*');
    }
    public static function getSolicitudTecnico($usuario){
        return vwSolicitudes::join('dnm_cosmeticos_si.POST.solicitudAsignaciones','dnm_cosmeticos_si.POST.vwSolicitudes.idSolicitud','dnm_cosmeticos_si.POST.solicitudAsignaciones.idSolicitud')
        ->where('dnm_cosmeticos_si.POST.solicitudAsignaciones.usuarioAsignado','like','%'.$usuario.'%')->select('dnm_cosmeticos_si.POST.vwSolicitudes.*');
    }


}
