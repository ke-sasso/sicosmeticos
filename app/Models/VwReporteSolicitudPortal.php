<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class VwReporteSolicitudPortal extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.SOL.vwReporteSolicitudPortal';    
    protected $primaryKey = 'numeroSolicitud';
    public $incrementing = false;
    public $timestamps = false;


    public static function getSolicitudesPortal($request){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.vwReporteSolicitudPortal')
				->select('*')
				->where(function($query) use ($request){
					if($request->has('idTitular')){                                        
                    	$query->where('idTitular',$request->idTitular);
                	}
                	if($request->has('idProfesional')){                                        
                    	$query->where('idProfesional',$request->idProfesional);
                	}
                	if($request->has('fechaInicio')){                                        
                    	$query->whereBetween('fecha',[$request->fechaInicio,$request->fechaFin]);
                	}
				})->get();
	}
}
