<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'user' => 'required|string|max:50|unique:api_users,user',
            'password' => 'required|string|min:8|max:50',
            'level' => 'required|integer|in:1,2,3',
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => 'El nombre de usuario es obligatorio.',
            'user.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'user.max' => 'El nombre de usuario no puede tener más de :max caracteres.',
            'user.unique' => 'El nombre de usuario ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.max' => 'La contraseña no puede tener más de :max caracteres.',
            'level.required' => 'El nivel es obligatorio.',
            'level.integer' => 'El nivel debe ser un número entero.',
            'level.in' => 'El nivel debe ser 1, 2 o 3.',
        ];
    }
}
