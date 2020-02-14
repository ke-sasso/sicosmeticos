<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MandamientoDetalle extends Model
{
  protected $table = 'cssp.cssp_mandamientos_detalle';
  protected $primaryKey = 'CORRELATIVO';
  public $timestamps = false;
  public $connection = 'mysql';
  protected $fillable = ['ID_CLIENTE','ID_TIPO_PAGO','VALOR','TIPO_ANUALIDAD','ID_FABRICANTE','RECARGO','COMENTARIOS','NOMBRE_CLIENTE','COMENTARIOS_ANEXOS'];

  public function mandamiento()
  {
    return $this->belongsTo('App\Models\Mandamiento','ID_MANDAMIENTO','ID_MANDAMIENTO');
  }
}
