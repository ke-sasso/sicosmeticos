<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;
use DB;

class AsignacionSolPost extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudAsignaciones';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','usuarioAsignado','usuarioCreacion','usuarioModificacion'];
	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}