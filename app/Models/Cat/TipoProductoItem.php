<?php

namespace App\Models\Cat;

use Illuminate\Database\Eloquent\Model;

class TipoProductoItem extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.CAT.tipoProductoItems';
    protected $fillable = [];
    protected $primaryKey='idTipoPItem';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public function item(){
        return $this->hasOne('App\Models\Item','idItem','itemId');
    }

    public function tipoProducto(){
        return $this->hasOne('App\Models\Cat\TipoProducto','idTipoP','tipoPId');
    }
}
