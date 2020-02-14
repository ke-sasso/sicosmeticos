<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;
use DB;

class DictamenDetalle extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.detalleDictamen';
	protected $primaryKey='idDetalle';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idDictamen','idRequisito','opcion','observacion','usuarioCreacion','usuarioModificacion'];

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
    public function dictamen(){
    	return $this->belongsTo('App\Models\SolicitudesPost\Dictamen','idDictamen','idDictamen');
    }
    public function requisito(){
    	return $this->hasOne('App\Models\SolicitudesPost\Requisito','idRequisito','idRequisito');
    }

}