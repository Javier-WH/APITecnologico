<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindUserRequest extends FormRequest
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
            'id' => 'required | uuid | exists:api_users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'El ID del usuario es obligatorio.',
            'id.uuid' => 'El ID del usuario debe ser un UUID válido.',
            'id.exists' => 'El usuario con el ID proporcionado no existe en la base de datos.',
        ];
    }
}
