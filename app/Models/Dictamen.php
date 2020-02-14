<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dictamen extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.DIC.dictamenesPre';
	protected $fillable = [];
	protected $primaryKey='idDictamen';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function getFechaCreacionAttribute()
    {
        return (date_create($this->attributes['fechaCreacion'])->format('Y-m-d H:i:s'));
    }

	public static function getItemsDictamenCos(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenItemsCat as id')
		->join('dnm_cosmeticos_si.DIC.dictamenApartados as a','id.apartadoRequisitos','=','a.idApartado')
		->select('id.idItemDictamen','id.nombreItem','id.apartadoRequisitos','a.nombreApartado')
		->where('id.estado','A')
		->where('a.aplicaCosmeticos',1)->get();
	}

	public static function getItemsDictamenHig(){
		return  DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenItemsCat as id')
		->join('dnm_cosmeticos_si.DIC.dictamenApartados as a','id.apartadoRequisitos','a.idApartado')
		->select('id.idItemDictamen','id.nombreItem','id.apartadoRequisitos','a.nombreApartado')
		->where('id.estado','A')
		->where('a.aplicaHigienicos',1)->orderBy('id.apartadoRequisitos')->get();
	}

	public static function getApartadosCos(){
		return  DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenApartados')
		->select('idApartado')->where('estado','A')->where('aplicaCosmeticos',1)->get();

	}
	public static function getApartadosHig(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenApartados')
		->select('idApartado')->where('estado','A')->where('aplicaHigienicos',1)->get();

	}

	public static function getInfoDictamen($idDic){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenesPre as d')
			->join('dnm_cosmeticos_si.DIC.dictamenDetalle as dd','d.idDictamen','dd.idDictamen')
			->join('dnm_cosmeticos_si.DIC.dictamenItemsCat as id','id.idItemDictamen','dd.idItem')
			->join('dnm_cosmeticos_si.SOL.solicitudes as s', 'd.idSolicitud', 's.idSolicitud')
			->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as ds', 's.idSolicitud', 'ds.idSolicitud')
			->select('d.idDictamen','id.nombreItem','d.idSolicitud','s.tipoSolicitud','ds.nombreComercial', 's.fechaCreacion','dd.idItem', DB::raw("CASE when dd.opcion=0 then 
				 	'NO CUMPLE' when dd.opcion=1 THEN 'CUMPLE' else 'NO APLICA' END as opcion"),'dd.observaciones')
			->where('d.idDictamen',$idDic)
			->orderBy('d.fechaCreacion','DESC')->get();

	}

	public static function getDictamenBySol($idSol,$idDic=null){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenesPre as d')
			->join('dnm_cosmeticos_si.DIC.dictamenDetalle as dd','d.idDictamen','dd.idDictamen')
			->join('dnm_cosmeticos_si.DIC.dictamenItemsCat as id','id.idItemDictamen','dd.idItem')
			->join('dnm_cosmeticos_si.SOL.solicitudes as s', 'd.idSolicitud', 's.idSolicitud')
			->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as ds', 's.idSolicitud', 'ds.idSolicitud')
			->select('d.idDictamen','id.nombreItem','d.idSolicitud','s.tipoSolicitud','ds.nombreComercial', 's.fechaCreacion','d.fechaCreacion','dd.idItem', DB::raw("CASE when dd.opcion=0 then 
				 	'NO CUMPLE' when dd.opcion=1 THEN 'CUMPLE' else 'NO APLICA' END as opcion"),'dd.observaciones')
			->where('d.idSolicitud',$idSol)
            ->where(function($query) use ($idDic){
                if($idDic!=null){
                    $query->where('d.idDictamen',$idDic);
                }
            })
			->orderBy('d.fechaCreacion','DESC')->first();

	}

	public static function getResolucion($idSol)
	{
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenesPre as dic')
					->join('dnm_cosmeticos_si.DIC.dictamenResolucion as res','res.idDictamen','=','dic.idDictamen')
					->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as est','est.idEstado','=','res.resolucion')
					->where('dic.idSolicitud',$idSol)->get();
	}

	public static function getItemObservados($idDictamen){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenDetalle as dd')
		->join('dnm_cosmeticos_si.DIC.dictamenItemsCat as di','di.idItemDictamen','dd.idItem')
		->select('di.nombreItem','dd.observaciones')
		->where('opcion',0)
		->where('dd.idDictamen',$idDictamen)->get();
	}

	public static function getIdsSol($user){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenesPre as dic')
		->select('idSolicitud')
		->where('idUsuarioCrea',$user)->groupBy('idSolicitud')->pluck('idSolicitud');
	}

	public static function getSolicitudesNotificadas(){
		$solicitudes=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.DIC.dictamenesPre as dic')
		->join('dnm_cosmeticos_si.DIC.dictamenResolucion as res','dic.idDictamen','res.idDictamen')
		->select('idSolicitud')
		->where('res.resolucion',12)->distinct()->pluck('idSolicitud');

		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.solicitudes as s')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','s.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','s.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','s.tipoSolicitud')
		->select('s.idSolicitud','s.numeroSolicitud','s.idProducto','s.fechaCreacion','s.fechaEnvio','s.idUsuarioCrea','s.solicitudPortal','tp.nombreTramite','sd.nombreComercial','e.estado','s.tipoSolicitud',DB::raw("CASE WHEN solicitudPortal=0 THEN 'UIEDM' ELSE 'Portal en línea' END as origen"),DB::raw("CASE WHEN solicitudPortal=0 THEN s.fechaCreacion ELSE s.fechaEnvio END as fecha"),'s.estado as idEstado')
		->whereIn('s.idSolicitud',$solicitudes)		
		->get();
	}


}