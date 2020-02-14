<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Higienico extends Model
{

	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.HIG.Higienicos';
	protected $fillable = [];
	protected $primaryKey='idHigienico';
    public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

    public function getFechaCreacionAttribute()
    {
        return (date_create($this->attributes['fechaCreacion'])->format('d-m-Y'));
    }

    public function titular12(){
       return $this->hasOne('App\Models\VwPropietario','nit','idTitular');
    }

    public function titular3(){
        return $this->hasOne('App\Models\Propietario','id_propietario','idTitular');
    }

    public function clasificacion(){
        return $this->belongsTo('App\Models\ClasificacionHig', 'idClasificacion', 'idClasificacion');
    }

    public function formula(){
        return $this->hasMany('App\Models\Higienicos\FormulaHigienicos', 'idHigienico', 'idHigienico');
    }

     public function presentaciones(){
        return $this->hasMany('App\Models\Higienicos\PresentacionesHigienicos', 'idHigienico', 'idHigienico');
    }

    public function marca(){
         return $this->belongsTo('App\Models\Marca', 'idMarca', 'idMarca');
    }

    public function Pais(){
        return $this->belongsTo('App\Models\Pais', 'idPaisOrigen', 'codigoId');
    }

    public function fragancias(){
        return $this->hasMany('App\Models\Higienicos\FraganciasHigienicos', 'idHigienico', 'idHigienico');
    }

    public function tonos(){
         return $this->hasMany('App\Models\Higienicos\TonosHigienicos', 'idHigienico', 'idHigienico');
    }

    public function profesional(){
        return $this->belongsTo('App\Models\Higienicos\ProfesionalesHigienicos', 'idHigienico', 'idHigienico');
    }

    public function distribuidores(){
        return $this->hasMany('App\Models\Higienicos\DistribuidoresHigienicos','idHigienico','idHigienico');
    }


	public static function getHigienicos(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.Higienicos')
				 ->select('idHigienico','nombreComercial', DB::raw("CASE when estado='A' then
				 	'ACTIVO' else 'INACTIVO' END as estado"),
				 	'vigenteHasta',DB::raw("CASE when tipo=1 then
				 	'REGISTRO HIGIENICO' else 'RECONOCIMIENTO HIGIENICO' END as tipo"));

    }

    public static function getHigienicosActivos($searchParam=null){
        return Higienico::where('estado','A')
            ->where(function($query) use ($searchParam){
                if($searchParam!=null){
                    $query->where('idHigienico','LIKE','%'.$searchParam.'%')
                        ->orWhere('nombreComercial','LIKE','%'.$searchParam.'%');
                }
            })
            ->select('idHigienico as idCosmetico','nombreComercial');
    }

/*    public static function getGenerales($id){
    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.Higienicos as hig')
    			 ->join('dnm_cosmeticos_si.CAT.marcas as mar','hig.idMarca','mar.idMarca')
    			 ->join('dnm_cosmeticos_si.HIG.clasificacion as cl','hig.idClasificacion','cl.idClasificacion')
    			 ->select('hig.*',DB::raw("CASE when hig.tipo=1 then
				 	'REGISTRO HIGIÉNICO' else 'RECONOCIMIENTO HIGIÉNICO' END as tipo"),'mar.nombreMarca','cl.nombreClasificacion',
                    DB::raw("CASE when hig.estado='A' then 'ACTIVO' else 'INACTIVO' END as estado"))
				 ->where('idHigienico',$id)->get();
    }

     public static function getPaisOrigen($id){
    	return DB::connection('sqlsrv')->table('dnm_catalogos.cat.paises as pa')
    	         ->select('nombre')->where('idPais',$id)->get();
    }

   	  public static function getClasificacion($id){
   	  	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.clasificacion')
    	         ->select('nombreClasificacion')->where('idClasificacion',$id)->get();
   	  }

   	  public static function getPropietarios($id){
    	return DB::table('cssp.cssp_propietarios as pp')
    			 ->join('dnm_catalogos.cat_paises as pais','pp.id_pais','=','pais.idPais')
				 ->select('pp.id_propietario','pp.nombre_propietario','pais.nombre', 'pp.direccion', 'pp.email', 'pp.telefono_1', DB::raw("CASE when pp.activo='A' then
				 	'ACTIVO' else 'INACTIVO' END as estado"))
				 ->where('pp.id_propietario',$id)->get();
    }*/

    public static function getPresentaciones($id){

    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.presentacionesHigienicos as p')
    			->leftjoin('dnm_cosmeticos_si.CAT.envases as ep','p.idEnvasePrimario','ep.idEnvase')
                ->leftjoin('dnm_cosmeticos_si.CAT.envases as es','p.idEnvaseSecundario','es.idEnvase')
    			->leftjoin('dnm_cosmeticos_si.CAT.materialesPresentaciones as mp','p.idMaterialPrimario','mp.idMaterial')
                ->leftjoin('dnm_cosmeticos_si.CAT.materialesPresentaciones as ms','p.idMaterialSecundario','ms.idMaterial')
    			->leftjoin('dnm_cosmeticos_si.CAT.medidas as med','p.idUnidad','med.idMedida')
    			->select('p.*','ep.nombreEnvase as eprimario','es.nombreEnvase as esecundario','mp.material as mprimario','ms.material as msecundario','med.medida','med.abreviatura')
    			->where('p.idHigienico',$id)->get();

    }


   /* public static function getFragancias($id){

    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.fraganciasHigienicos as f')
    			->select('f.*')
    			->where('idHigienico',$id)->get();

    }

    public static function getTonos($id){
    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.tonosHigienicos as t')
    			->select('t.*')
    			->where('idHigienico',$id)->get();

    }*/

    public static function getImportadores($id){
     $idImpor=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.importadoresHigienicos')
                ->select('idImportador')
                ->where('idHigienico',$id)->pluck('idImportador');

    return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos')
                ->select('idEstablecimiento', 'nombreComercial','direccion', 'telefonosContacto','emailContacto',DB::raw('DATE_FORMAT(vigenteHasta,"%d/%m/%Y") as vigenteHasta'),
                    DB::raw("CASE when estado='A' then 'ACTIVO' else 'INACTIVO' END as estado"))
                ->whereIn('idEstablecimiento',$idImpor)
                ->get();

    }

    public static function getDistribuidoresHig($id){
      $idDis=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.distribuidoresHigienicos')
            ->select('idPoder')->where('idHigienico',$id)->pluck('idPoder');

     return DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as dp')
            ->join('cssp.cssp_establecimientos as e','dp.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
            ->select('dp.ID_DISTRIBUIDOR_MAQUILA','dp.ID_PODER','e.NOMBRE_COMERCIAL','e.DIRECCION','e.TELEFONO_1','dp.ESTADO','e.EMAIL')
            ->whereIN('id_poder',$idDis)->get();
    }

    public static function getFabricantes($id){

            $idFab=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.fabricantesHigienicos as f')
            ->select('f.*')
            ->where('idHigienico',$id)->pluck('idFabricante');


        $consulta1= DB::connection('mysql')->table('dnm_establecimientos_si.vw_dnm_cssp_establecimientos')
            ->select('idEstablecimiento as ID_ESTABLECIMIENTO','nombreComercial as NOMBRE_COMERCIAL','direccion AS DIRECCION','telefonosContacto as TELEFONO_1',DB::raw('DATE_FORMAT(vigenteHasta,"%d/%m/%Y") as VIGENTE_HASTA'),'emailContacto AS EMAIL','pais')
            ->whereIn('idEstablecimiento',$idFab);

        $consulat2= DB::connection('mysql')->table('dnm_catalogos.vwfabricantesextrajeros')
            ->select('idFabricanteExtranjero as ID_ESTABLECIMIENTO','nombreFabricante as NOMBRE_COMERCIAL','direccion AS DIRECCION','telefonos as TELEFONO_1',DB::raw('"N/A" as VIGENCIA_HASTA'),'correoElectronico AS EMAIL','nombrePais as pais')
            ->whereIn('idFabricanteExtranjero',$idFab)
            ->union($consulta1)
            ->get();


        return $consulat2->unique('ID_ESTABLECIMIENTO');

    }

    public static function existeFabri($id){
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.fabricantesHigienicos')
        ->where('idHigienico',$id)->get();
    }

     public static function getProfesional($idProfesional,$idPoder){
         return DB::connection('mysql')->table('cssp.cssp_profesionales as pro')
             ->join('cssp.siic_profesionales_poderes as p','pro.ID_PROFESIONAL','p.ID_PROFESIONAL')
             ->join('dnm_catalogos.dnm_persona_natural as nat','nat.nitNatural','=','pro.NIT')
             ->select('pro.ID_PROFESIONAL','pro.ID_PROFESIONAL_ANTIGUO AS CORRELATIVO',DB::Raw('ifnull(nat.NOMBRES,pro.NOMBRES) as NOMBRES'),DB::Raw('ifnull(nat.APELLIDOS,pro.APELLIDOS) as APELLIDOS'),'pro.DUI','pro.NIT','nat.DIRECCION',DB::Raw('ifnull(nat.telefonosContacto,pro.TELEFONO_1) as TELEFONO_1'),DB::Raw('ifnull(nat.emailsContacto,pro.EMAIL) as EMAIL'),'p.ID_PODER','p.ID_PROPIETARIO')
             ->where('p.ID_PODER',$idPoder)->where('pro.ID_PROFESIONAL',$idProfesional)
             ->whereExists(function ($query) {
                 $query->select(DB::raw(1))
                     ->from('cssp.siic_profesionales_poderes as pp')
                     ->whereRaw('pp.ID_PROFESIONAL = pro.ID_PROFESIONAL');
             }) ->first();

    }

     public static function existeProf($id){
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.profesionalesHigienicos')
        ->where('idHigienico',$id)->get();
    }

    /*public static function getFormula($id){
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.formulaHigienico as fc')
        ->join('dnm_cosmeticos_si.CAT.formulaHig as f','fc.idDenominacion','f.idDenominacion')
        ->select('fc.porcentaje','f.numeroCAS','f.nombreSustancia as denominacionINCI')->where('idHigienico',$id)->get();
    }
*/
    public static function obtenerCorrelativoCos($fecha)
    {
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.Higienicos as c')
        ->selectRaw("max(SUBSTRING(right(idHigienico,8),1,4))+1 as correlativo,tipo")
        ->where('tipo','1')
        ->whereRaw("(idHigienico like '1%H%' or idHigienico like '1UH%') and cast(right(idHigienico,2) as int) = right(year(getdate()),2)")
        ->groupBy('tipo')->first();

    }

     public static function obtenerCorrelativoRec($tipo,$fecha){
       return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.Higienicos as h')
        ->selectRaw("CASE
            WHEN (max(SUBSTRING(idHigienico,4,4)) + 1) <= 9 THEN CONCAT('000', max(SUBSTRING(idHigienico,4,4)) + 1)
            WHEN (max(SUBSTRING(idHigienico,4,4)) + 1) <= 99 THEN CONCAT('00', max(SUBSTRING(idHigienico,4,4)) + 1)
            WHEN (max(SUBSTRING(idHigienico,4,4)) + 1) <= 999 THEN CONCAT('0', max(SUBSTRING(idHigienico,4,4)) + 1)
            WHEN (max(SUBSTRING(idHigienico,4,4)) + 1) <= 9999 THEN  max(SUBSTRING(idHigienico,4,4)) + 1
            END as correlativo, tipo")
        ->where('tipo','2')
        ->where('idHigienico','like',$tipo)
        ->whereRaw('YEAR(fechaCreacion) =?', $fecha)
        ->groupBy('tipo')->get();
    }

}