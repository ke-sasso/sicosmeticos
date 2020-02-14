<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GruposFormas extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.COS.gruposFormas';
	protected $fillable = [];
	protected $primaryKey='idGrupo';
	public $timestamps = false;


	public static function getGrupos($id){

		$items="";

		$formas= DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.gruposFormas as g')
				->join('dnm_cosmeticos_si.COS.formaCosmetica as f','g.idForma','f.idForma')
				->where('g.idClasificacion',$id)
				->where('f.estado','A')
				->select('f.idForma','f.nombreForma')->get();
				$items.="<option></option>";

		foreach ($formas as $f) {
			$items .="<option value='".$f->idForma."'>".$f->nombreForma."</option>";
		}
		return $items;

	}


}
