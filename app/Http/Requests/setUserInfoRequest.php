<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class setUserInfoRequest extends FormRequest
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
            'user_id' => 'required|uuid|unique:api_user_info,user_id|exists:api_users,id',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'ci' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:api_user_info,email',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'description' => 'required|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'El ID de usuario es obligatorio.',
            'user_id.uuid' => 'El ID de usuario debe ser un UUID válido.',
            'user_id.exists' => 'El ID de usuario no existe en la tabla api_users.',
            'user_id.unique' => 'El ID de usuario ya está en uso.',
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser una cadena de texto.',
            'first_name.max' => 'El nombre no puede tener más de 50 caracteres.',
            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto.',
            'last_name.max' => 'El apellido no puede tener más de 50 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no puede tener más de 50 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.string' => 'El teléfono debe ser una cadena de texto.',
            'phone.max' => 'El teléfono no puede tener más de 50 caracteres.',
            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no puede tener más de 100 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede tener más de 200 caracteres.',
        ];
    }

}
