<?php

namespace App\Models\Cat;

use Illuminate\Database\Eloquent\Model;

class vwFabricantesCosHig extends Model
{
    protected $table = 'dnm_cosmeticos_si.CAT.vwFabricantesCosHig';
    protected $primaryKey = 'idFabricante';
    public  $incrementing = false;
    public $timestamps = false;
    public $connection = 'sqlsrv';
}
