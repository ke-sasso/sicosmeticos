<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleDictamen extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.DIC.dictamenDetalle';
	protected $fillable = [];
	protected $primaryKey='idDetDictamen';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

}