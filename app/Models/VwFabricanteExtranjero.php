<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwFabricanteExtranjero extends Model
{
    //
    protected $table = 'dnm_catalogos.vwfabricantesextrajeros';
    protected $connection = 'mysql';
    protected $primaryKey = 'idFabricanteExtranjero';
    public $incrementing = false;
    public $timestamps = false;
}
