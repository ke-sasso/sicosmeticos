<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;



class FormulaCosmetico extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.formulaCosmetico';
	protected $primaryKey='idCorrelativo';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function sustancias(){
		return $this->hasMany('App\Models\SustanciaCosmetico', 'idDenominacion', 'idDenominacion');
	}

	public static function getSustancias(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaINCI')
		->select('idDenominacion','numeroCAS','denominacionINCI', DB::raw("CASE when estado='A' then 
				 	'ACTIVO' else 'INACTIVO' END as estado"))
		->where('estado','A')->take(100)->get();
	}

		public static function getSustanciasFormulaCos($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.formulaCosmetico as fc')
		->join('dnm_cosmeticos_si.CAT.formulaINCI as f','fc.idDenominacion','f.idDenominacion')
		->select('fc.idDenominacion','fc.porcentaje','f.numeroCAS','f.denominacionINCI')->where('idSolicitud',$id)->get();
	}

		public static function getFormulasCosmeticos($denominacion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaINCI')
		->select('idDenominacion','numeroCAS','denominacionINCI')
		->where('numeroCAS','like','%'.$denominacion.'%')
		->orWhere('denominacionINCI','like','%'.$denominacion.'%')
		->where('estado','A')->take(25)->get();
	}

	public static function getFormulaINCI($idDen){
	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaINCI')
		->select('idDenominacion','numeroCAS','denominacionINCI')
		->where('estado','A')
		->where('idDenominacion',$idDen)->get();

		}

		public function getPorcentajeAttribute($value){
		return (float)$value;
	}

}
