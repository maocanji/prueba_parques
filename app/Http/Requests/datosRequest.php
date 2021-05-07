<?php

namespace App\Http\Requests;

use App\Models\Model\Datos;
use Illuminate\Foundation\Http\FormRequest;


class datosRequest extends FormRequest
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

    public function rules()
    {
        return [


//            'email' => 'required|string|email|max:255|unique:datos|regex:/minambiente.gov.co]/',
//            'email' => 'required|unique:datos|max:255|regex:/minambiente.gov.co]/',
            'email' => 'required|unique:datos|max:255',
            'departamento' => 'required',
            'municipio' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'emaril requerido',
            'municipio.required' => 'Municipio requeridos',
            'departamento.required' => 'Departamento requeridos',


        ];
    }
}
