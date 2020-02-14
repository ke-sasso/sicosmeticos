<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_catalogos.cat.paises';
	protected $fillable = [];
	protected $primaryKey='idPais';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';


	public function getPaisesSelect($nombre){
		return DB::connection('mysql')->table('dnm_catalogos.cat.paises')
		->select('idPais','nombre')->where('activo','A')->get()->take(10);

	}
}