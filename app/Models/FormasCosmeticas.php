<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FormasCosmeticas extends Model
{
     protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.formaCosmetica';
	protected $fillable = [];
	protected $primaryKey='idForma';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	
}