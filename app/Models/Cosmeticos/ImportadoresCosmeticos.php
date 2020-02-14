<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class ImportadoresCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.importadoresCosmeticos';
	protected $fillable = [];
	protected $primaryKey='idCosmetico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}