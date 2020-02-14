<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwPropietario extends Model
{
    //
    protected $table = 'dnm_catalogos.vwpropietarios';
    protected $connection = 'mysql';
    protected $primaryKey = 'nit';
    public $incrementing = false;
    public $timestamps = false;
}
