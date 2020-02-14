<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolFechaReconocimiento extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudFechaReconocimiento';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','fecha','usuarioCreacion','usuarioModificacion'];

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}