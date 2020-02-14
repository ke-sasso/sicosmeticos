<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudesDetalle extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.solicitudesDetalle';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function solicitudes(){
		return $this->hasMany('App\Models\Solicitud', 'idSolicitud', 'idSolicitud');
	}

	public function marca(){
		return $this->belongsTo('App\Models\Marca', 'idMarca', 'idMarca');
	}

	public function pais(){
		return $this->belongsTo('App\Models\Pais', 'idPais', 'codigoId');
	}

	public function detallecosmetico(){
		return $this->belongsTo('App\Models\DetalleCosmetico', 'idDetalle', 'idDetalle');
	}

	public function detallehigienico(){
		return $this->belongsTo('App\Models\DetalleHigienico', 'idDetalle', 'idDetalle');
	}

	public static function getDetalle($idSol){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd')
		->join('dnm_cosmeticos_si.CAT.marcas as m','m.idMarca','sd.idMarca')
		->select('sd.*','m.nombreMarca')->where('idSolicitud',$idSol)->get();
	}

	

	public static function getImportadoresSol($idSol){
		 $idImpor=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.importadores')
                ->select('idImportador')
                ->where('idSolicitud',$idSol)->pluck('idImportador');

		 return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos')
                ->select('idEstablecimiento', 'nombreComercial','direccion', DB::raw("replace(replace(telefonosContacto,'}',']'),'{','[') as telefonosContacto"),'emailContacto','vigenteHasta',
                    DB::raw("CASE when estado='A' then 'ACTIVO' else 'INACTIVO' END as estado"))
                ->whereIn('idEstablecimiento',$idImpor)
                ->get();
	}

	public static function getTonosSol($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.tonos')
				->select('tono')->where('idSolicitud',$id)->get();

	}

	public static function getFraganciasSol($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.fragancias')
				->select('fragancia')->where('idSolicitud',$id)->get();

	}

	public static function getPresentaciones($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.presentaciones as p')
				->leftjoin('dnm_cosmeticos_si.CAT.envases as ep','p.idEnvasePrimario','ep.idEnvase')
                ->leftjoin('dnm_cosmeticos_si.CAT.envases as es','p.idEnvaseSecundario','es.idEnvase')
    			->leftjoin('dnm_cosmeticos_si.CAT.materialesPresentaciones as mp','p.idMaterialPrimario','mp.idMaterial')
                ->leftjoin('dnm_cosmeticos_si.CAT.materialesPresentaciones as ms','p.idMaterialSecundario','ms.idMaterial')
    			->leftjoin('dnm_cosmeticos_si.CAT.medidas as med','p.idUnidad','med.idMedida')
    			->select('p.*','ep.nombreEnvase as eprimario','es.nombreEnvase as esecundario','mp.material as mprimario','ms.material as msecundario','med.abreviatura as medida')
    			->where('p.idSolicitud',$id)->get();
	}

	public static function getDocumentosSol($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.documentosSol as ds')
				->leftjoin('dnm_cosmeticos_si.SOL.detalleDocumentos as dd', 'ds.idDetalleDoc','dd.idDoc')
				->join('dnm_cosmeticos_si.SOL.items as i','i.idItem','ds.idItemDoc')
				->select('dd.idDoc','ds.idItemDoc','dd.urlArchivo','dd.tipoArchivo','i.nombreItem')->where('ds.idSolicitud',$id)->get();
	}

	public static function getDocumento($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.documentosSol as ds')
				->leftjoin('dnm_cosmeticos_si.SOL.detalleDocumentos as dd', 'ds.idDetalleDoc','dd.idDoc')
				->join('dnm_cosmeticos_si.SOL.items as i','i.idItem','ds.idItemDoc')
				->select('dd.idDoc','ds.idItemDoc','dd.urlArchivo','dd.tipoArchivo','i.nombreItem')->where('dd.idDoc',$id)->get();
	}

	
}