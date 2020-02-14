<?php

namespace App\Models\SolicitudesPre;

use Illuminate\Database\Eloquent\Model;

class HistorialAsignacion extends Model
{
  protected $connection = 'sqlsrv';
  protected $fillable = [];
  protected $primaryKey='id';
  protected $table = 'dnm_cosmeticos_si.SOL.historialAsignacionesPre';
  const CREATED_AT = 'fechaCreacion';
  //public $timestamps = false;

  public function solicitud()
  {
    return $this->belongsTo('App\Models\Solicitud','idSolicitud','idSolicitud');
  }
}
