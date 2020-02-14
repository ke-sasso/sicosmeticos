<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class SolPresentacion extends Model
{
    //
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudPresentacion';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','idEnvasePrimario','contenidoPrimario','idUnidad','idEnvaseSecundario','idMaterialSecundario','contenidoSecundario','peso','idMedida','nombrePresentacion','textoPresentacion','usuarioCreacion','usuarioModificacion'];

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}
