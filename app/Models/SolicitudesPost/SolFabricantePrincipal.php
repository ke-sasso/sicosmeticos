<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class SolFabricantePrincipal extends Model
{
    //
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudFabricantePrincipal';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','idFabricante','nombreComercial','idAccion','usuarioCreacion','usuarioModificacion'];

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}
