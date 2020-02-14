<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FabExtUnidadReg extends Model
{
	
	protected $table = 'dnm_catalogos.dnm_fab_ext_unidad_reg';
	protected $fillable = [];
	protected $primaryKey='id';
	protected $connection = 'mysql';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}