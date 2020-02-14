<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FormulaHigienico extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.formulaHigienico';
	protected $fillable = [];
	protected $primaryKey='idCorrelativo';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function sustancias(){
			return $this->hasMany('App\Models\SustanciaHigienico', 'idDenominacion', 'idDenominacion');
		}

	public static function getFormulasHigienicos($denominacion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaHig')
		->select('idDenominacion','numeroCAS','nombreSustancia as denominacionINCI')
		->where('numeroCAS','like','%'.$denominacion.'%')
		->orWhere('nombreSustancia','like','%'.$denominacion.'%')
		->where('estado','A')->take(25)->get();
	}

	public static function getSustanciasHig(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaHig')
		->select('idDenominacion','numeroCAS','nombreSustancia',DB::raw("CASE when estado='A' then 
				 	'ACTIVO' else 'INACTIVO' END as estado"))
		->where('estado','A')->take(100)->get();
	}

		public static function getSustanciasFormulaHig($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.formulaHigienico as fc')
		->join('dnm_cosmeticos_si.CAT.formulaHig as f','fc.idDenominacion','f.idDenominacion')
		->select('fc.idDenominacion','fc.porcentaje','f.numeroCAS','f.nombreSustancia as denominacionINCI')->where('idSolicitud',$id)->get();
	}

	public static function getFormulaHig($idDen){
	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaHig')
		->select('idDenominacion','numeroCAS','nombreSustancia as denominacionINCI')
		->where('estado','A')
		->where('idDenominacion',$idDen)->get();

		}

	public function getPorcentajeAttribute($value){
		return (float)$value;
	}


}
