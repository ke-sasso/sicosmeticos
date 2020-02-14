<?php

namespace App\Models\Cat;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.CAT.tiposProducto';
    protected $fillable = [];
    protected $primaryKey='idTipoP';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}
