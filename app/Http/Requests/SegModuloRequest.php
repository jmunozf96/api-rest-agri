<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SegModuloRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'idTModulo' => 'required|exists:SEG_TIPOMODULO,id',
                    'nombre' => 'required|string|between:2,100|unique:SEG_MODULO',
                    'descripcion' => 'required|string|max:250',
                    'url' => 'required|string|max:300',
                    'icon' => 'required|string'
                ];
            case 'PATCH':
                return [
                    'nombre' => 'required|string|between:2,100|unique:SEG_MODULO',
                    'descripcion' => 'required|string|max:250',
                ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'type' => 'error',
            'message' => 'Error en validacion de datos.',
            'error' => $validator->errors()
        ], 500));
    }
}
