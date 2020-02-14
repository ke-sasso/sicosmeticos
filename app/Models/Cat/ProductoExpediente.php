<?php

namespace App\Models\Cat;

use Illuminate\Database\Eloquent\Model;

class ProductoExpediente extends Model
{
    //
    protected $connection = 'sqlsrv';
    protected $table = 'dnm_cosmeticos_si.CAT.productoExpediente';
    protected $primaryKey='productoId';
    protected $fillable = ['productoId','archivoExpId','itemId','usuarioCreacion','usuarioModificacion'];
    public $incrementing = false;
    const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';


    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

    public function archivoExpediente(){
        return $this->hasOne('App\Models\Cat\ArchivoExpediente','idArchivoExp','archivoExpId');

    }


}
