<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SegGrupoRequest extends FormRequest
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
            'nombre.unique' => "El grupo ya se encuentra registrado.",
            'nombre.required' => "El nombre del grupo es necesario.",
            'descripcion.required' => "La descripción es necesaria."
        ];
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
