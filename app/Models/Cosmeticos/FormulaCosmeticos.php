<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class FormulaCosmeticos extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.formulaCosmetico';
	protected $fillable = ['idDenominacion','porcentaje','idUsuarioCreacion'];
	protected $primaryKey='idCosmetico';

    public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function sustancias(){
		return $this->hasMany('App\Models\SustanciaCosmetico', 'idDenominacion', 'idDenominacion');
	}
	public function sustancia(){
		return $this->hasOne('App\Models\SustanciaCosmetico', 'idDenominacion', 'idDenominacion');
	}

	 public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
	public static function getSustancias(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaINCI')
		->select('idDenominacion','numeroCAS','denominacionINCI', DB::raw("CASE when estado='A' then
				 	'ACTIVO' else 'INACTIVO' END as estado"))
		->where('estado','A')->take(100)->get();
	}



}
