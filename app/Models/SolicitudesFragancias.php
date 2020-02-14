<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudesFragancias extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.fragancias';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}