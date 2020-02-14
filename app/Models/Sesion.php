<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sesion extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SES.sesiones';
	protected $fillable = [];
	protected $primaryKey='idSesion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

	public function solicitudesPost(){
	    return $this->belongsToMany('App\Models\SolicitudesPost\Solicitud','dnm_cosmeticos_si.SES.solicitudesSesion','idSesion','idSolicitud')
                    ->where('idEstado',6)->where('tipoSolicitud',2);
    }

    public function solicitudesPostCertificar(){
        return $this->belongsToMany('App\Models\SolicitudesPost\vwSolicitudes','dnm_cosmeticos_si.SES.solicitudesSesion','idSesion','idSolicitud')
            ->whereIn('idEstado',[7,9,15])->where('tipoSolicitud',2);
    }

	public static function getSesiones(){

		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones')
		->select('idSesion','nombreSesion','fechaSesion',DB::raw("CASE WHEN estadoSesion=1 THEN 'EN CURSO' ELSE 'CERRADA' END as estadoSesion"))
		->orderBy('nombreSesion', 'DESC')
		->get();
	}

	public static function getSesion($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones')
		->where('idSesion',$id)
		->get();
	}
	public static function getIdSesion($nomsesion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones')
		->select('idSesion')->where('nombreSesion',$nomsesion)->get();
	}

	public static function getSolicitudesParaAprobar($nomsesion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->join('dnm_cosmeticos_si.SOL.solicitudes as sol','sol.idSolicitud','ss.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','sol.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','sol.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','sol.tipoSolicitud')
		->select('sol.idSolicitud','tp.nombreTramite','sd.nombreComercial','e.estado','ss.estadoSolSesion')
		->where('s.nombreSesion',$nomsesion)
		->where('ss.tipoSolicitud',1)
		->whereIn('ss.estadoSolSesion',[0,1])  //estados 0= ingresada, 1= aprobada para entrar a sesión
		->get();

	}
	public static function getSolicitudesParaAprobarPost($idSesion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->join('dnm_cosmeticos_si.POST.vwSolicitudes as sol','sol.idSolicitud','ss.idSolicitud')
		->select('sol.*','ss.estadoSolSesion','s.estadoSesion')
		->where('s.idSesion',$idSesion)
		->where('ss.tipoSolicitud',2)
		->whereIn('ss.estadoSolSesion',[0,1])  //estados 0= ingresada, 01= aprobada para entrar a sesión
		->get();

	}

	public static function getSolicitudesSesion($nombresesion){
		//return $nombresesion;
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->join('dnm_cosmeticos_si.SOL.solicitudes as sol','sol.idSolicitud','ss.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','sol.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','sol.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','sol.tipoSolicitud')
		->select('sol.idSolicitud','tp.nombreTramite','sd.nombreComercial','e.estado')
		->where('ss.tipoSolicitud',1)
		->where('s.nombreSesion',$nombresesion)->get();

	}

	public static function getSolicitudesParaCertificar($nombresesion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->join('dnm_cosmeticos_si.SOL.solicitudes as sol','sol.idSolicitud','ss.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','sol.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','sol.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','sol.tipoSolicitud')
		->select('sol.idSolicitud','sol.idProducto','tp.nombreTramite','sd.nombreComercial','e.estado','ss.estadoSolSesion','sol.estado as solestado','s.nombreSesion')
		->where('s.nombreSesion',$nombresesion)
		->where('ss.tipoSolicitud',1)
		->whereIN('sol.estado',[9,7,8,15])
		->get();
	}
	public static function getConsultaProducto($search,$tipo){
		 //tipo 1.Solicitudes PRE  2. Solicitudes POST
		if($tipo==1){
				return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
				->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
				->join('dnm_cosmeticos_si.SOL.solicitudes as sol','sol.idSolicitud','ss.idSolicitud')
				->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','sol.idSolicitud','sd.idSolicitud')
				->select('sol.idSolicitud','sol.idProducto','sd.nombreComercial','s.nombreSesion')
				->where(function($query) use ($search){
		                         $query->where('sd.nombreComercial','LIKE','%'.$search.'%')->orWhere('sol.idProducto','LIKE','%'.$search.'%');
		         })
				->where('ss.tipoSolicitud',1)
				//->whereIN('sol.estado',[9,7,8])
				->first();
	     }else{
	     	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
				->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
				->join('dnm_cosmeticos_si.POST.solicitudes as sol','sol.idSolicitud','ss.idSolicitud')
				->select('sol.idSolicitud','sol.noRegistro','sol.nombreComercial','s.nombreSesion')
				->where(function($query) use ($search){
		                         $query->where('sol.nombreComercial','LIKE','%'.$search.'%')->orWhere('sol.noRegistro','LIKE','%'.$search.'%');
		         })
				->where('ss.tipoSolicitud',2)
				//->whereIN('sol.estado',[9,7,8])
				->first();
	     }
	}

	public static function getSolicitudesCertificadas($nombresesion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->join('dnm_cosmeticos_si.SOL.solicitudes as sol','sol.idSolicitud','ss.idSolicitud')
		->select('sol.idSolicitud')
		->where('ss.tipoSolicitud',1)
		->where('s.nombreSesion',$nombresesion)
		->where('sol.estado',9)
		->get();
	}
	public static function getSesionSolicitudPre($idSolicitud){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->select('s.nombreSesion','s.fechaSesion')
		->where('ss.tipoSolicitud',1)
		->where('ss.idSolicitud',$idSolicitud)
		->first();
	}
	public static function getSesionSolicitudPost($idSolicitud){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones as s')
		->join('dnm_cosmeticos_si.SES.solicitudesSesion as ss','s.idSesion','ss.idSesion')
		->select('s.nombreSesion','s.fechaSesion')
		->where('ss.tipoSolicitud',2)
		->where('ss.idSolicitud',$idSolicitud)
		->first();
	}
}