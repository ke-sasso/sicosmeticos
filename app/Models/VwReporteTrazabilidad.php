<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Fabricantes;
use App\Models\Dictamen;

class VwReporteTrazabilidad extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.SOL.vwReporteTrazabilidad';    
    protected $primaryKey = 'numeroSolicitud';
    public $incrementing = false;
    public $timestamps = false;


    public static function getTrazabilidadSolicitudes($request){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.vwReporteTrazabilidad')
				->select('*')
				->where(function($query) use ($request){
                    if($request->has('idsolicitud')){                                        
                        $query->where('numeroSolicitud',$request->idsolicitud);
                    }
                    if($request->has('tecAsignado')){  
                        $ids=Dictamen::getIdsSol($request->tecAsignado);                                      
                        $query->whereIn('numeroSolicitud',$ids);
                    }
                    if($request->has('numPresentacion')){                                        
                        $query->where('numeroPresentacion',$request->numPresentacion);
                    }
                    if($request->has('numRegistro')){                                        
                        $query->where('idProducto',$request->numRegistro);
                    }
                    if($request->has('nomSolicitud')){                                        
                        $query->where('tipoSolicitud',$request->nomSolicitud);
                    }
                    if($request->has('nomComercial')){                                        
                        $query->where('nombreProducto','like','%'.$request->nomComercial.'%');
                                            }
					if($request->has('idTitular')){                                        
                    	$query->where('idTitular',$request->idTitular);
                	}
                	if($request->has('idProfesional')){                                        
                    	$query->where('idProfesional',$request->idProfesional);
                	}
                	if($request->has('fechaInicio')){                                        
                    	$query->whereBetween('fecha',[$request->fechaInicio,$request->fechaFin]);
                	}
                    if($request->has('fechaInicioCos') || $request->has('fechaFinCos')){                                
                        $query->whereBetween('fechaCreacionCos',[$request->fechaInicioCos,$request->fechaFinCos]);
                    }
                    if($request->has('fechaInicioHig') || $request->has('fechaFinHig')){                                
                        $query->whereBetween('fechaCreacionHig',[$request->fechaInicioHig,$request->fechaFinHig]);
                    }
                    if($request->has('idFabricante')){     
                        $ids=Fabricantes::where('idFabricante',$request->idFabricante)->pluck('idSolicitud');
                        $query->whereIn('numeroSolicitud',$ids);
                    }
                    if($request->has('estadoSol')){                                        
                        $query->where('estado',$request->estadoSol);
                    }
				})->get();
	}
}
