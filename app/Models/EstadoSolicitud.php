<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoSolicitud extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.SOL.estadosSolicitudes';
    protected $primaryKey='idEstado';
    public $timestamps = false;

    public static function activosAll(){
        return EstadoSolicitud::where('activo','A')->whereNotIn('idEstado',[0,10,9])->get();
    }
}
