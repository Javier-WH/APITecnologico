<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user' => 'required|string|max:50',
            'password' => 'required|string|min:8|max:50'
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'El campo de usuario es obligatorio.',
            'user.string' => 'El campo de usuario debe ser una cadena de texto.',
            'user.max' => 'El campo de usuario no puede tener más de 50 caracteres.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'password.string' => 'El campo de contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 50 caracteres.'
        ];
    }
}
