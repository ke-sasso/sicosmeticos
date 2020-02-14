<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudFabricantes extends Model
{	
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.fabricantes';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
    
//validar si quitarlos
    public static function getFabNacionalesSolicitu($id){
    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.fabricantes as f')
            ->select('idFabricante')
            ->where('idSolicitud',$id)
            ->where('idFabricante','not like','E30%')->pluck('idFabricante');
    }

    public static function getFabExtranjerosSolicitu($id){
     	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.fabricantes as f')
            ->select('idFabricante')
            ->where('idSolicitud',$id)
            ->where('idFabricante','like','E30%')->pluck('idFabricante');
    }


    public static function getDetalleFabricantesNac($ids){
		return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
		->select('e.idEstablecimiento as idEstablecimiento','e.nombreComercial as nombreFab',DB::raw("replace(replace(telefonosContacto,'}',']'),'{','[') as telefonosContacto"), 'e.direccion','e.emailContacto')
		->whereIn('e.idEstablecimiento',$ids)->get();
	}

	public static function getDetalleFabricantesExt($ids){
		return DB::connection('mysql')->table('cssp.cssp_establecimientos as e')
		->select('e.ID_ESTABLECIMIENTO as idEstablecimiento','e.NOMBRE_COMERCIAL as nombreFab','e.TELEFONO_1 as telefonosContacto', 'e.direccion','e.email as emailContacto')
		->whereIn('e.ID_ESTABLECIMIENTO',$ids)->get();
	}

	public static function getFabNacionalesSolicitud($id){
		 $ids=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.fabricantes as f')
            ->select('idFabricante')
            ->where('idSolicitud',$id)
            ->where('tipoFabricante',1)
            ->pluck('idFabricante');

		 return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
		->select('e.idEstablecimiento as idEstablecimiento','e.nombreComercial as nombreFab',DB::raw("replace(replace(telefonosContacto,'}',']'),'{','[') as telefonosContacto"), 'e.direccion','e.emailContacto')
		->whereIn('e.idEstablecimiento',$ids)->get();
	}

	public static function getFabExtranjerosSolicitud($id){
		 $ids=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.fabricantes as f')
            ->select('idFabricante')
            ->where('idSolicitud',$id)
            ->where('tipoFabricante',2)
            ->pluck('idFabricante');

		 return DB::connection('mysql')->table('dnm_catalogos.vwfabricantesextrajeros as e')
		->select('e.idFabricanteExtranjero as idEstablecimiento','e.nombreFabricante as nombreFab','e.telefonos as telefonosContacto', 'e.direccion','e.correoElectronico as emailContacto')
		->whereIn('e.idFabricanteExtranjero',$ids)->get();
	}
}
