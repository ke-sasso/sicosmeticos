<?php

namespace App\Models\dnm_catalogos;

use Illuminate\Database\Eloquent\Model;

class Profesionales extends Model
{
    //
    protected $table = 'dnm_catalogos.dnm_profesionales';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['idProfesional','idPersonaNatural'];


}
