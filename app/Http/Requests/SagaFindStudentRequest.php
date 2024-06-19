<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SagaFindStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "ci" => "required|numeric| exists:alumnos,cedulapasaporte"
        ];
    }
    public function messages(): array
    {
        return [
            'ci.required' => 'No ha suministrado una cédula de identidad.',
            'ci.numeric' => 'La cédula de identidad debe ser un número entero.',
            'ci.exists' => 'El usuario con la cédula de identidad proporcionada no está registrado.',
        ];
    }

}
