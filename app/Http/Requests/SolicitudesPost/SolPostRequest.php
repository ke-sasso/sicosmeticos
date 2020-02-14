<?php

namespace App\Http\Requests\SolicitudesPost;

use Illuminate\Foundation\Http\FormRequest;

class SolPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipoProducto'      => 'required',
            'idCosmetico'       => 'sometimes|required_if:tipoProducto,COS',
            'idHigienicos'      => 'sometimes|required_if:tipoProducto,HIG',
            'nombreComercial'   => 'required',
            'nitPersona'        => 'required',
            'idMand'            => 'required',
            'idTramite'         => 'required'
        ];
    }

    public function attributes()
    {
        return[
            'tipoProducto'      => 'Tipo Producto',
            'idCosmetico'       => 'No Registro Cosmètico',
            'idHigienicos'      => 'No Registro Higiénico',
            'nombreComercial'   => 'Nombre Comercial',
            'nitPersona'        => 'NIT Solicitante',
            'idMand'            => 'Número de mandamiento',
            'idTramite'         => 'Tipo Trámite'

        ];
    }

    public function messages()
    {
        return[
            'tipoProducto.required'      => 'Tipo Producto es requerido',
            'idCosmetico.required_if'    => 'No Registro Cosmètico es requerido',
            'idHigienicos.required_if'   => 'No Registro Higiénico es requerido',
            'nombreComercial.required'   => 'Nombre Comercial es requerido',
            'nitPersona.requ    ired'    => 'NIT Solicitante es requerido',
            'idMand.required'            => 'Número de mandamiento es requerido',
            'idTramite.required'         => 'Tipo Trámite es requerido'
        ];
    }


}
