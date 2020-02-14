<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SesSolictudesAprobadas extends Model
{

	protected $table = 'dnm_sesiones_si.ses_solicitudes_aprobadas';
	protected $fillable = ['idRegistro','nombreRegistro','nombreTitular','nombreFabricante','idSolicitud','idUnidad','tipoSolicitud','nombreTramite','idSesion','fechaSolicitud','fechaSesion','usuarioAprobacion','fechaAprobacion','idSistema'];
	protected $primaryKey='idFabricanteExtranjero';
	public $connection = 'mysql';
	public $incrementing = false;
    public $timestamps = false;

}