<?php

namespace App\Models\Higienicos;

use Illuminate\Database\Eloquent\Model;
use DB;

class TonosHigienicos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.tonosHigienicos';
	protected $fillable = ['idHigienico','tono','estado','idUsuarioCrea','idUsuarioModificacion'];
	protected $primaryKey='idHigienico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}