<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposTramites extends Model
{
   protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.tiposTramites';
	protected $fillable = [];
	protected $primaryKey='idTramite';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


    public function solicitudes(){
		return $this->hasMany('App\Models\Solicitud', 'tipoSolicitud', 'idTramite');
	}
	public static function acticosAll(){
		return TiposTramites::where('estado','A')->get();
	}

}
