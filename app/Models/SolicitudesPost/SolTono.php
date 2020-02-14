<?php

namespace App\Models\SolicitudesPost;

use Illuminate\Database\Eloquent\Model;

class SolTono extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.POST.solicitudTono';
    protected $fillable = ['tono','usuarioCreacion'];
    protected $primaryKey='idItem';
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }
}
