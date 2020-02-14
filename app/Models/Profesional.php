<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profesional extends Model
{

	protected $table = 'cssp.cssp_profesionales';
    protected $connection = 'mysql';
	protected $fillable = [];
	protected $primaryKey='ID_PROFESIONAL';
    public $incrementing = false;
    public $timestamps = true;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

    public static function getProfesional($idProfesional){

        return DB::connection('mysql')->table('cssp.cssp_profesionales as pro')

                ->select('pro.ID_PROFESIONAL',DB::raw('CONCAT(pro.NOMBRES," ",pro.APELLIDOS) as NOMBREPROF'))
                ->where('pro.id_profesional',$idProfesional)->get();

    }

      public static function getProfesionalByPoder($poderProfesional){
 
        return DB::connection('mysql')->table('cssp.cssp_profesionales as pro')

                ->select('pro.ID_PROFESIONAL',DB::raw('CONCAT(pro.NOMBRES," ",pro.APELLIDOS) as NOMBREPROF'))
                ->where('pro.id_profesional',$idProfesional)->get();

    }

    public static function getTratamientoProfesional($idProfesional){

        return DB::connection('mysql')->table('cssp.cssp_profesionales as pro')
                ->leftjoin('dnm_catalogos.dnm_persona_natural as pn','pro.NIT','pn.nitNatural')
                ->leftjoin('dnm_catalogos.cat_tratamiento as tra','pn.idTipoTratamiento','tra.idTipoTratamiento')
                ->select('tra.abreviaturaTratamiento as tratamiento',DB::raw('CONCAT(pro.NOMBRES," ",pro.APELLIDOS) as NOMBREPROF'))
                ->where('pro.id_profesional',$idProfesional)->first();

    }




}
