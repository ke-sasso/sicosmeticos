<?php

namespace App\Models\dnm_catalogos\cat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;


class DiasFeriados extends Model{
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_catalogos.cat.dias_feriados';
    protected $primaryKey = 'idDia';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}