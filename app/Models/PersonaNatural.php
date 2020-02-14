<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PersonaNatural extends Model
{
    protected $connection = 'mysql';
	protected $table = 'dnm_persona_natural';
	protected $fillable = [];
	protected $primaryKey='nitNatural';
	public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
}