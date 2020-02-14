<?php

namespace App\Models\Higienicos;

use Illuminate\Database\Eloquent\Model;

class FormulaHigienicos extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.formulaHigienico';
	protected $fillable = ['idDenominacion','porcentaje','idUsuarioCreacion'];
	protected $primaryKey='idHigienico';
    public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function sustancias(){
		return $this->hasMany('App\Models\SustanciaHigienico', 'idDenominacion', 'idDenominacion');
	}
	public function sustancia(){
		return $this->hasOne('App\Models\SustanciaHigienico', 'idDenominacion', 'idDenominacion')->select('idDenominacion','numeroCAS','nombreSustancia as denominacionINCI');
	}

}
