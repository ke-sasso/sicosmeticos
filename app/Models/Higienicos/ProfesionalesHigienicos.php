<?php

namespace App\Models\Higienicos;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProfesionalesHigienicos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.profesionalesHigienicos';
	protected $fillable = [];
	protected $primaryKey='idHigienico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

    public function profesional(){
        return $this->hasOne('App\Models\Profesional','ID_PROFESIONAL','idProfesional');
    }
}