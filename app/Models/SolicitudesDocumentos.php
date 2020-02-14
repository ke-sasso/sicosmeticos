<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudesDocumentos extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.documentosSol';
	protected $fillable = [];
	public $incrementing=false;
	//protected $primaryKey='idSolicitud';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
	public $timestamps = false;
	protected  $with=['item'];

    public function item(){
        return $this->hasOne('App\Models\Item','idItem','idItemDoc');
    }

}