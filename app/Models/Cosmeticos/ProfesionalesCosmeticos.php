<?php

namespace App\Models\Cosmeticos;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProfesionalesCosmeticos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.profesionalesCosmeticos';
	protected $fillable = [];
	protected $primaryKey='idCosmetico';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


    public function profesional(){
        return $this->hasOne('App\Models\Profesional','ID_PROFESIONAL','idProfesional');
    }

}