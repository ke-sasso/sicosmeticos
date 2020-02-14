<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleDocumentos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.detalleDocumentos';
	protected $fillable = [];
	protected $primaryKey='idDoc';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}