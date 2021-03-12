<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SegTipoModuloRequest extends FormRequest
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
                    'nombre' => 'required|string|between:2,100|unique:SEG_GRUPO',
                    'descripcion' => 'required|string|max:250',
                ];
            case 'PATCH':
                return [
                    'nombre' => 'required|string|between:2,100',
                    'descripcion' => 'required|string|max:250',
                ];
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'nombre.unique' => "El tipo de modulo ya se encuentra registrado.",
            'nombre.required' => "El nombre es necesario.",
            'descripcion.required' => "La descripción es necesaria."
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'type' => config('global.error_validation'),
            'message' => $validator->errors()
        ], 500));
    }
}
