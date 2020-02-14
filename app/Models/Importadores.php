<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Importadores extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.importadores';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}