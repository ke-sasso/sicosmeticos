<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;
use DB;

class SolicitudSeguimiento extends Model
{
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudSeguimiento';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','idEstado','seguimiento','usuarioCreacion','usuarioModificacion'];

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}