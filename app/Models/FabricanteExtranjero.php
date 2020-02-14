<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FabricanteExtranjero extends Model
{
	
	protected $table = 'dnm_catalogos.dnm_fabricantes_extranjeros';
	protected $fillable = [];
	protected $primaryKey='idFabricanteExtranjero';
	public $incrementing = false;
    public $timestamps = true;
    public $connection = 'mysql';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public static function getFabricantesExtra(){
 
        return DB::connection('mysql')->table('dnm_fabricantes_extranjeros as fe')
        		->join('cat_paises as p','fe.codigoIdPais','p.codigoId')
                ->select(DB::raw("fe.idFabricanteExtranjero, fe.nombreFabricante, p.nombre, fe.telefonos, fe.correoElectronico, (CASE when fe.estado='A' then 'ACTIVO' else 'INACTIVO' END) estado"));

    }

    public static function getFabricantesEstado($estado){
 
        return DB::connection('mysql')->table('dnm_fabricantes_extranjeros as fe')
        		->join('cat_paises as p','fe.codigoIdPais','p.codigoId')
                ->select(DB::raw("fe.idFabricanteExtranjero, fe.nombreFabricante, p.nombre, fe.telefonos, fe.correoElectronico, (CASE when fe.estado='A' then 'ACTIVO' else 'INACTIVO' END) estado"))
                ->where('estado',$estado);

    }

    public static function getPaises(){
    	return DB::connection('mysql')->table('cat_paises')
    			->select('nombre','codigoId')
    			->where('activo','A')
    			->orderBy('nombre','asc')->get();
    }
}