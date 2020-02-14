<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Cosmetico extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.Cosmeticos';

	protected $fillable = [];
	protected $primaryKey='idCosmetico';
    public $incrementing = false;
   public $timestamps = true;
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


    public function presentaciones(){
        return $this->hasMany('App\Models\Cosmeticos\PresentacionesCosmeticos', 'idCosmetico', 'idCosmetico');
    }

    public function formula(){
        return $this->hasMany('App\Models\Cosmeticos\FormulaCosmeticos', 'idCosmetico', 'idCosmetico');
    }

    public function clasificacion(){
        return $this->belongsTo('App\Models\ClasificacionCos', 'idClasificacion', 'idClasificacion');
    }

    public function marca(){
         return $this->belongsTo('App\Models\Marca', 'idMarca', 'idMarca');
    }

    public function forma(){
         return $this->belongsTo('App\Models\FormasCosmeticas', 'idForma', 'idForma');
    }

    public function Pais(){
        return $this->belongsTo('App\Models\Pais', 'idPaisOrigen', 'codigoId');
    }

    public function profesional(){
        return $this->belongsTo('App\Models\Cosmeticos\ProfesionalesCosmeticos', 'idCosmetico', 'idCosmetico');
    }

    public function distribuidores(){
        return $this->hasMany('App\Models\Cosmeticos\DistribuidoresCosmeticos','idCosmetico','idCosmetico');
    }

    public function fragancias(){
        return $this->hasMany('App\Models\Cosmeticos\FraganciasCosmeticos', 'idCosmetico', 'idCosmetico');
    }

    public function tonos(){
        return $this->hasMany('App\Models\Cosmeticos\TonosCosmeticos', 'idCosmetico', 'idCosmetico');
    }

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

	public static function getCosmeticos($searchParam=null){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.Cosmeticos')

                 ->where(function($query) use ($searchParam){
                     if($searchParam!=null){
                         $query->where('estado','A')
                               ->where('idCosmetico','LIKE','%'.$searchParam.'%')
                               ->orWhere('nombreComercial','LIKE','%'.$searchParam.'%');
                     }
                 })
				 ->select(DB::raw("idCosmetico,nombreComercial,(CASE when estado='A' then
				 	'ACTIVO' else 'INACTIVO' END) as estado,
				 	vigenciaHasta, (CASE when tipo=1 then
				 	'REGISTRO COSMÉTICO' else 'RECONOCIMIENTO COSMÉTICO' END) as tipo"));


    }

 /*   public static function getGenerales($id){
    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.Cosmeticos as cos')
    			 ->join('dnm_cosmeticos_si.CAT.marcas as mar','cos.idMarca','mar.idMarca')
    			 ->join('dnm_cosmeticos_si.COS.formaCosmetica as fc','cos.idForma','fc.idForma')

    			 ->select('cos.*','cos.tipo as idtipo',DB::raw("CASE when cos.tipo=1 then
				 	'REGISTRO COSMÉTICO' else 'RECONOCIMIENTO COSMÉTICO' END as tipo"),'mar.nombreMarca','fc.nombreForma','cos.idPaisOrigen',
                    DB::raw("CASE when cos.estado='A' then 'ACTIVO' else 'INACTIVO' END as estado"))
				 ->where('idCosmetico',$id)->get();

    }


    public static function getClasificacion($id){
    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.clasificacion as clas')
    			->join('dnm_cosmeticos_si.COS.areasAplicacion as ar','clas.idArea','ar.idAreaAplicacion')
    			->select('clas.nombreClasificacion','ar.*','clas.idArea')
    			->where('clas.idClasificacion',$id)
    			->get();

    }

    public static function getPaisOrigen($id){
    	return DB::connection('sqlsrv')->table('dnm_catalogos.cat.paises as pa')
    	         ->select('nombre')->where('idPais',$id)->get();
    }

    public static function getPresentaciones($id){

    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.presentacionesCosmeticos as p')
    			->leftjoin('dnm_cosmeticos_si.CAT.envases as ep','p.idEnvasePrimario','ep.idEnvase')
                ->leftjoin('dnm_cosmeticos_si.CAT.envases as es','p.idEnvaseSecundario','es.idEnvase')
    			->leftjoin('dnm_cosmeticos_si.CAT.materialesPresentaciones as mp','p.idMaterialPrimario','mp.idMaterial')
                ->leftjoin('dnm_cosmeticos_si.CAT.materialesPresentaciones as ms','p.idMaterialSecundario','ms.idMaterial')
    			->leftjoin('dnm_cosmeticos_si.CAT.medidas as med','p.idUnidad','med.idMedida')
    			->select('p.*','ep.nombreEnvase as eprimario','es.nombreEnvase as esecundario','mp.material as mprimario','ms.material as msecundario','med.medida','med.abreviatura')
    			->where('p.idCosmetico',$id)->get();

    }



    public static function getFragancias($id){

    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.fraganciasCosmeticos as f')
    			->select('f.*')
    			->where('idCosmetico',$id)->get();

    }

    public static function getTonos($id){
    	return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.tonosCosmeticos as t')
    			->select('t.*')
    			->where('idCosmetico',$id)->get();

    }
*/


    public static function getFabricantes($id){
    	$idFab=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.fabricantesCosmeticos as f')
    			->select('f.*')
    			->where('idCosmetico',$id)->pluck('idFabricante');


        $consulta1= DB::connection('mysql')->table('dnm_establecimientos_si.vw_dnm_cssp_establecimientos')
            ->select('idEstablecimiento as ID_ESTABLECIMIENTO','nombreComercial as NOMBRE_COMERCIAL','direccion AS DIRECCION','telefonosContacto as TELEFONO_1',DB::raw('DATE_FORMAT(vigenteHasta,"%d/%m/%Y") as VIGENTE_HASTA'),'emailContacto AS EMAIL','pais')
            ->whereIn('idEstablecimiento',$idFab);

        $consulat2= DB::connection('mysql')->table('dnm_catalogos.vwfabricantesextrajeros')
            ->select('idFabricanteExtranjero as ID_ESTABLECIMIENTO','nombreFabricante as NOMBRE_COMERCIAL','direccion AS DIRECCION','telefonos as TELEFONO_1',DB::raw('"N/A" as VIGENCIA_HASTA'),'correoElectronico AS EMAIL','nombrePais as pais')
            ->whereIn('idFabricanteExtranjero',$idFab)
            ->union($consulta1)->get();

        return $consulat2->unique('ID_ESTABLECIMIENTO');

    }

    public static function existeFabri($idCosmetico){
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.fabricantesCosmeticos')
        ->where('idCosmetico',$idCosmetico)->get();
    }

    public static function getImportadores($id){
     $idImpor=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.importadoresCosmeticos')
                ->select('idImportador')
                ->where('idCosmetico',$id)->pluck('idImportador');

        $impor=DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos')
                    ->select('idEstablecimiento', 'nombreComercial','direccion', DB::raw("replace(replace(telefonosContacto,'{','['),'}',']') as telefonosContacto"),'emailContacto',DB::raw('DATE_FORMAT(vigenteHasta,"%d/%m/%Y") as vigenteHasta'),
                        DB::raw("CASE when estado='A' then 'ACTIVO' else 'INACTIVO' END as estado"))
                    ->whereIn('idEstablecimiento',$idImpor)
                    ->get();
      return $impor;

        $impor[0]->telefonosContacto= str_replace('{', '',$impor[0]->telefonosContacto);
                    $impor[0]->telefonosContacto = str_replace('}', '', $impor[0]->telefonosContacto);
                    $impor[0]->telefonosContacto= str_replace('"telefono1":', '', $impor[0]->telefonosContacto);
                    $impor[0]->telefonosContacto = str_replace('"telefono2":', '', $impor[0]->telefonosContacto);


    }

    public static function getDistribuidoresCos($id){
     $idDis=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.distribuidoresCosmeticos')
            ->select('idPoder')->where('idCosmetico',$id)->pluck('idPoder');

     return DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as dp')
            ->join('cssp.cssp_establecimientos as e','dp.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
            ->select('dp.ID_DISTRIBUIDOR_MAQUILA','dp.ID_PODER','e.NOMBRE_COMERCIAL','e.DIRECCION','e.TELEFONO_1','dp.ESTADO','e.EMAIL')
            ->whereIN('id_poder',$idDis)->get();
    }

   /* public static function getDistribuidores($id){
     $idImpor=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.distribuidoresCosmeticos')
                ->select('idPoder')
                ->where('idCosmetico',$id)->pluck('idPoder');

    return DB::table('cssp.cssp_poderes')
                ->select('ID_PODER','DESCRIPCION')
                ->whereIn('idEstablecimiento',$idImpor)
                ->get();

    }*/

    public static function getProfesional($idProfesional,$idPoder){
        return DB::connection('mysql')->table('cssp.cssp_profesionales as pro')
                ->join('cssp.siic_profesionales_poderes as p','pro.ID_PROFESIONAL','p.ID_PROFESIONAL')
                ->leftjoin('dnm_catalogos.dnm_persona_natural as nat','nat.nitNatural','=','pro.NIT')
                ->select('pro.ID_PROFESIONAL','pro.ID_PROFESIONAL_ANTIGUO AS CORRELATIVO',DB::Raw('ifnull(nat.NOMBRES,pro.NOMBRES) as NOMBRES'),DB::Raw('ifnull(nat.APELLIDOS,pro.APELLIDOS) as APELLIDOS'),'pro.DUI','pro.NIT','nat.DIRECCION',DB::Raw('ifnull(nat.telefonosContacto,pro.TELEFONO_1) as TELEFONO_1'),DB::Raw('ifnull(nat.emailsContacto,pro.EMAIL) as EMAIL'),'p.ID_PODER','p.ID_PROPIETARIO')
                ->where('p.ID_PODER',$idPoder)->where('pro.ID_PROFESIONAL',$idProfesional)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                      ->from('cssp.siic_profesionales_poderes as pp')
                      ->whereRaw('pp.ID_PROFESIONAL = pro.ID_PROFESIONAL');
                })->first();

    }

    public static function existeProf($idCosmetico){
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.profesionalesCosmeticos')
        ->where('idCosmetico',$idCosmetico)->first();
    }

    public static function getFormula($idCosmetico){
        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.formulaCosmetico as fc')
        ->join('dnm_cosmeticos_si.CAT.formulaINCI as f','fc.idDenominacion','f.idDenominacion')
        ->select('fc.porcentaje','f.numeroCAS','f.denominacionINCI')->where('idCosmetico',$idCosmetico)->get();

    }

    public static function obtenerCorrelativoCos($fecha){

        return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.Cosmeticos as c')
        ->selectRaw("max(SUBSTRING(right(idCosmetico,8),1,4))+1 as correlativo,tipo")
        ->where('tipo','1')
        ->whereRaw("(idCosmetico like '1%C%' or idCosmetico like '1UC%')and cast(right(idCosmetico,2) as int) = right(year(getdate()),2)")

        ->groupBy('tipo')->first();

    }

    public static function obtenerCorrelativoRec($tipo,$fecha){

        $cos = DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.getCorrelativoReconocimientos')
        ->select(DB::Raw('isnull((max(SUBSTRING(right(idProducto,8),1,4))+1),1) as correlativo'))->first();

        return $cos;
    }

    public static function getProfesionalCosmetico($idProfesional){

        return DB::connection('mysql')->table('cssp.cssp_profesionales as pro')
                ->select('pro.ID_PROFESIONAL',DB::raw('CONCAT(pro.NOMBRES," ",pro.APELLIDOS) as NOMBREPROF'))
                ->where('pro.id_profesional',$idProfesional)->get();

    }

    public static function getPaisReconocimiento($idPais){
        return DB::connection('sqlsrv')->table('dnm_catalogos.cat.paises')
        ->select('nombre')->get();
    }

    public static function existeTitular($id)
    {
        return DB::connection('sqlsrv')
        ->table('dnm_cosmeticos_si.COS.Cosmeticos')
        ->select('idTitular')
        ->where('idCosmetico',$id)->get();
    }
}
