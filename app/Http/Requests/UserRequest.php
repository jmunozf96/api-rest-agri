<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
                    'name' => 'required|string|between:2,100|unique:SEG_USUARIO',
                    'email' => 'required|string|email|max:100|unique:SEG_USUARIO',
                    'password' => 'required|string|confirmed|min:6',
                ];
            case 'PATCH':
                return [
                    'name' => 'required|string|between:2,100|unique:SEG_USUARIO,name,' . $this->get('id'),
                    'email' => 'required|string|email|max:100|unique:SEG_USUARIO,email,' . $this->get('id'),
                    'password' => 'required|string|confirmed|min:6',
                ];
            default:
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'type' => config('global.error_validation'),
            'message' => $validator->errors(),
        ], 500));
    }
}
