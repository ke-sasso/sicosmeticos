<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mandamiento extends Model
{
  protected $table = 'cssp.cssp_mandamientos';
  protected $primaryKey = 'ID_MANDAMIENTO';
  public $incrementing = false;
  public $connection = 'mysql';
  const CREATED_AT = 'FECHA_CREACION';
  const UPDATED_AT = 'FECHA_MODIFICACION';

  protected $fillable = ['ID_MANDAMIENTO','CODIGO_BARRA','CODIGO_BARRA_TEXTO','NPE','FECHA','HORA','ID_CLIENTE','A_NOMBRE','FECHA_VENCIMIENTO','ID_JUNTA','TOTAL','NOMBRE_CLIENTE','POR_CUENTA','ID_USUARIO_CREACION'];

	public function detalle()
    {
	    return $this->hasMany('App\Models\MandamientoDetalle','ID_MANDAMIENTO','ID_MANDAMIENTO');
	}
   public static function last(){
        return DB::connection('mysql')->select(DB::raw('SELECT MAX(ID_MANDAMIENTO)+1  AS LAST_ID FROM cssp.cssp_mandamientos'));
    }
    public static function npe($total){
        return DB::connection('mysql')->select(DB::raw('SELECT cssp.COD_NPE("'.$total.'") AS COD_NPE'));
    }
    public static function codBarra($total){
        return  DB::connection('mysql')->select(DB::raw('SELECT cssp.COD_BARRA("'.$total.'") AS COD_BARRA'));
    }
    public  static function codBarraTexto($total){
        return  DB::connection('mysql')->select(DB::raw('SELECT cssp.COD_BARRA_TEXTO("'.$total.'") AS COD_BARRA_TEXTO'));
    }
    public static function fechaVencimiento(){
        return  DB::connection('mysql')->select(DB::raw("SELECT REPLACE(CURDATE() + INTERVAL 60 DAY,'-','/') AS VENCIMIENTO"));
    }

}
