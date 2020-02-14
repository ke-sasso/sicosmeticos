<?php

namespace App\Models\Higienicos;

use Illuminate\Database\Eloquent\Model;
use DB;

class FabricantesHigienicos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.fabricantesHigienicos';
	protected $fillable = [];
	protected $primaryKey='idHigienico';
	public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}