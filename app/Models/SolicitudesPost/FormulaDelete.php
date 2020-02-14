<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class FormulaDelete extends Model
{
    //
    protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.POST.solicitudFormulaDelete';
	protected $primaryKey='idItem';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	protected $fillable = ['idSolicitud','idPrimary','idDenominacion','usuarioCreacion','usuarioModificacion'];

	public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
    public function sustanciaHig(){
		return $this->hasOne('App\Models\SustanciaHigienico', 'idDenominacion', 'idDenominacion')->select('idDenominacion','numeroCAS','nombreSustancia as denominacionINCI');
	}
	public function sustanciaCos(){
		return $this->hasOne('App\Models\SustanciaCosmetico', 'idDenominacion', 'idDenominacion');
	}


}
