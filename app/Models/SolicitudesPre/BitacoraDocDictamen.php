<?php

namespace App\Models\SolicitudesPre;

use Illuminate\Database\Eloquent\Model;
use DB;

class BitacoraDocDictamen extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.dictamenBitacoraDoc';
	protected $primaryKey='idBitacora';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idResolucion','idTipo','urlArchivo','estado','usuarioCreacion','usuarioModificacion'];
	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public static function documentoResolucion($idResolucion){
    	return BitacoraDocDictamen::where('idResolucion',$idResolucion)->where('estado',1)->where('idTipo',2)->first();
    }
    public static function documentoHerramienta($idResolucion){
    	return BitacoraDocDictamen::where('idResolucion',$idResolucion)->where('estado',1)->where('idTipo',1)->first();
    }

}