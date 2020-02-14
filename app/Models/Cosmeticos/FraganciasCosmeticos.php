<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class FraganciasCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.fraganciasCosmeticos';
	protected $fillable = ['idCosmetico','fragancia','estado','idUsuarioCrea','idUsuarioModificacion'];
	protected $primaryKey='idCosmetico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}