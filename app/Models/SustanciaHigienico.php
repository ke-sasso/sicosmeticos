<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;



class SustanciaHigienico extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.CAT.formulaHig';
	protected $fillable = [];
	protected $primaryKey='idDenominacion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function formula(){
		return $this->belongsTo('App\Models\Higienicos\FormulaHigienicos', 'idDenominacion', 'idDenominacion');
	}

}