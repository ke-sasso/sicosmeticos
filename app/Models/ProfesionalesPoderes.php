<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use GuzzleHttp\Client;
use Config;
use App\Models\Propietario;
use App\Models\Profesional;

class ProfesionalesPoderes extends Model
{   

    protected $table = 'cssp.siic_profesionales_poderes';

    protected $fillable = [];
    protected $primaryKey='ID_PODER';

    public $incrementing = false;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';
    private $url=null;
    private $token=null;
    public $connection = 'mysql';
      public function profesional(){
        return $this->belongsTo('App\Models\Profesional', 'ID_PROFESIONAL', 'ID_PROFESIONAL');
    }

    public function propietario(){
        return $this->belongsTo('App\Models\Propietario', 'ID_PROPIETARIO', 'ID_PROPIETARIO');
    }

   /*public function getProfesionalPropietario($idProfesional,$idPropietario){
        return DB::select("SELECT pf.ID_PROFESIONAL,pf.CORRELATIVO,pf.NOMBRES,pf.APELLIDOS,pf.DUI,pf.NIT,
                            pf.DIRECCION,pf.TELEFONO_1,pf.EMAIL, 
                            (SELECT pro.NOMBRE_PROPIETARIO FROM cssp.siic_profesionales_poderes as pp
                            join cssp.cssp_propietarios as pro on pp.ID_PROPIETARIO=pro.ID_PROPIETARIO 
                            where pro.ID_PROPIETARIO = '".$idPropietario."' limit 1) as NOMBRE_PROPIETARIO 
                            FROM cssp.siic_profesionales_poderes as pp
                            join cssp.cssp_profesionales as pf on pp.ID_PROFESIONAL=pf.ID_PROFESIONAL 
                            where pf.ID_PROFESIONAL =  '".$idProfesional."'");
    }*/

  public static function getProfesionalPropietario($idProfesional,$idPropietario){
        return DB::connection('mysql')->table('cssp.siic_profesionales_poderes as pp')
                  ->join('cssp.cssp_profesionales as pf','pp.ID_PROFESIONAL','pf.ID_PROFESIONAL')
                  ->select('pf.ID_PROFESIONAL','pf.CORRELATIVO','pf.NOMBRES','pf.APELLIDOS','pf.DUI',
                          'pf.NIT','pf.DIRECCION','pf.TELEFONO_1','pf.EMAIL',
                    DB::raw("(SELECT pro.NOMBRE_PROPIETARIO FROM cssp.siic_profesionales_poderes as pp
                            inner join cssp.cssp_propietarios as pro on pp.ID_PROPIETARIO=pro.ID_PROPIETARIO 
                            where pro.ID_PROPIETARIO = '".$idPropietario."' limit 1) as NOMBRE_PROPIETARIO"))
                  ->where('pf.ID_PROFESIONAL',$idProfesional)->get();
    }

}