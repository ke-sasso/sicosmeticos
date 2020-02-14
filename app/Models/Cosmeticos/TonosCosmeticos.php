<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class TonosCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.tonosCosmeticos';
	protected $fillable = ['idCosmetico','tono','estado','idUsuarioCrea','idUsuarioModificacion'];
	protected $primaryKey='idCosmetico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}