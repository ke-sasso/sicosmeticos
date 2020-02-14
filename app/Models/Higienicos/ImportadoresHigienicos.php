<?php

namespace App\Models\Higienicos;

use Illuminate\Database\Eloquent\Model;
use DB;

class ImportadoresHigienicos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.importadoresHigienicos';
	protected $fillable = [];
	protected $primaryKey='idHigienico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}