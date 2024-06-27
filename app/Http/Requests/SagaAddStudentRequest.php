<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class SagaAddStudentRequest extends FormRequest
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
        if ($this->isMethod('put')) {
            return [
                'cedulapasaporte' => 'numeric|unique:alumnos,cedulapasaporte',
                'nombre' => 'string|max:50',
                'apellido' => 'string|max:50',
                'nacionalidad_id' => 'numeric|exists:nacionalidads,id',
                'sexo_id' => 'numeric|exists:sexos,id',
                'fechanacimiento' => 'date',
                'lugarnacimiento' => 'string|max:100',
                'direccion' => 'string|max:100',
                'parroquia_id' => 'numeric|exists:parroquias,id',
                'telefono1' => 'string|max:50',
                'telefono2' => 'string|max:50',
                'email1' => 'string|max:50',
                'email2' => 'string|max:50',
                'provieneinstitucion' => 'string|max:100',
                'fechaegresoinstitucion' => 'date',
                'tienerusnies' => 'boolean|nullable',
                'esrusnies' => 'boolean|nullable',
                'snirusnies' => 'numeric|nullable',
                'semestre' => 'string|max:50',
                'opcion' => 'numeric|nullable',
                'esimpedido' => 'string|max:2|in:SI,NO',
                'discapacidad_id' => 'numeric|exists:discapacidads,id',
                'etnia_id' => 'numeric|exists:etnias,id',
            ];
        }else if($this->isMethod('post')){
            return [
                'cedulapasaporte' => 'required|numeric|unique:alumnos,cedulapasaporte',
                'nombre' => 'required|string|max:50',
                'apellido' => 'required|string|max:50',
                'nacionalidad_id' => 'required|numeric|exists:nacionalidads,id',
                'sexo_id' => 'required|numeric|exists:sexos,id',
                'fechanacimiento' => 'required|date',
                'lugarnacimiento' => 'required|string|max:100',
                'direccion' => 'required|string|max:100',
                'parroquia_id' => 'required|numeric|exists:parroquias,id',
                'telefono1' => 'required|string|max:50',
                'telefono2' => 'required|string|max:50',
                'email1' => 'required|string|max:50',
                'email2' => 'required|string|max:50',
                'provieneinstitucion' => 'required|string|max:100',
                'fechaegresoinstitucion' => 'required|date',
                'tienerusnies' => 'required|boolean|nullable',
                'esrusnies' => 'required|boolean|nullable',
                'snirusnies' => 'required|numeric|nullable',
                'semestre' => 'required|string|max:50',
                'opcion' => 'required|numeric|nullable',
                'esimpedido' => 'required|string|max:2|in:SI,NO',
                'discapacidad_id' => 'required|numeric|exists:discapacidads,id',
                'etnia_id' => 'required|numeric|exists:etnias,id',
            ];
        }
    }

    public function messages()
    {
        return [
            'cedulapasaporte.required' => 'El campo cédula/pasaporte es obligatorio.',
            'cedulapasaporte.numeric' => 'El campo cédula/pasaporte debe ser un número.',
            'cedulapasaporte.unique' => 'El número de cédula/pasaporte ya está registrado.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El campo nombre no puede tener más de 50 caracteres.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'apellido.string' => 'El campo apellido debe ser una cadena de texto.',
            'apellido.max' => 'El campo apellido no puede tener más de 50 caracteres.',
            'nacionalidad_id.required' => 'El campo nacionalidad es obligatorio.',
            'nacionalidad_id.numeric' => 'El campo nacionalidad debe ser un número.',
            'nacionalidad_id.exists' => 'La nacionalidad seleccionada no existe.',
            'sexo_id.required' => 'El campo sexo es obligatorio.',
            'sexo_id.numeric' => 'El campo sexo debe ser un número.',
            'sexo_id.exists' => 'El sexo seleccionado no existe.',
            'fechanacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fechanacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'lugarnacimiento.required' => 'El campo lugar de nacimiento es obligatorio.',
            'lugarnacimiento.string' => 'El campo lugar de nacimiento debe ser una cadena de texto.',
            'lugarnacimiento.max' => 'El campo lugar de nacimiento no puede tener más de 100 caracteres.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.string' => 'El campo dirección debe ser una cadena de texto.',
            'direccion.max' => 'El campo dirección no puede tener más de 100 caracteres.',
            'parroquia_id.required' => 'El campo parroquia es obligatorio.',
            'parroquia_id.numeric' => 'El campo parroquia debe ser un número.',
            'parroquia_id.exists' => 'La parroquia seleccionada no existe.',
            'telefono1.required' => 'El campo teléfono 1 es obligatorio.',
            'telefono1.string' => 'El campo teléfono 1 debe ser una cadena de texto.',
            'telefono1.max' => 'El campo teléfono 1 no puede tener más de 50 caracteres.',
            'telefono2.required' => 'El campo teléfono 2 es obligatorio.',
            'telefono2.string' => 'El campo teléfono 2 debe ser una cadena de texto.',
            'telefono2.max' => 'El campo teléfono 2 no puede tener más de 50 caracteres.',
            'email1.required' => 'El campo correo electrónico 1 es obligatorio.',
            'email1.string' => 'El campo correo electrónico 1 debe ser una cadena de texto.',
            'email1.max' => 'El campo correo electrónico 1 no puede tener más de 50 caracteres.',
            'email2.required' => 'El campo correo electrónico 2 es obligatorio.',
            'email2.string' => 'El campo correo electrónico 2 debe ser una cadena de texto.',
            'email2.max' => 'El campo correo electrónico 2 no puede tener más de 50 caracteres.',
            'provieneinstitucion.required' => 'El campo proviene de institución es obligatorio.',
            'provieneinstitucion.string' => 'El campo proviene de institución debe ser una cadena de texto.',
            'provieneinstitucion.max' => 'El campo proviene de institución no puede tener más de 100 caracteres.',
            'fechaegresoinstitucion.required' => 'El campo fecha de egreso de institución es obligatorio.',
            'fechaegresoinstitucion.date' => 'El campo fecha de egreso de institución debe ser una fecha válida.',
            'tienerusnies.required' => 'El campo tiene Rusnies es obligatorio.',
            'tienerusnies.boolean' => 'El campo tiene Rusnies debe ser 1 o 0.',
            'tienerusnies.nullable' => 'El campo tiene Rusnies puede ser nulo.',
            'esrusnies.required' => 'El campo es Rusnies es obligatorio.',
            'esrusnies.boolean' => 'El campo es Rusnies debe ser 1 o 0.',
            'esrusnies.nullable' => 'El campo es Rusnies puede ser nulo.',
            'snirusnies.required' => 'El campo SNI Rusnies es obligatorio.',
            'snirusnies.numeric' => 'El campo SNI Rusnies debe ser un número.',
            'snirusnies.nullable' => 'El campo SNI Rusnies puede ser nulo.',
            'semestre.required' => 'El campo semestre es obligatorio.',
            'semestre.string' => 'El campo semestre debe ser una cadena de texto.',
            'semestre.max' => 'El campo semestre no puede tener más de 50 caracteres.',
            'opcion.required' => 'El campo opción es obligatorio.',
            'opcion.numeric' => 'El campo opción debe ser un número.',
            'opcion.nullable' => 'El campo opción puede ser nulo.',
            'esimpedido.required' => 'El campo es impedido es obligatorio.',
            'esimpedido.string' => 'El campo es impedido debe ser una cadena de texto.',
            'esimpedido.max' => 'El campo es impedido no puede tener más de 2 caracteres.',
            'esimpedido.in' => 'El valor del campo es impedido debe ser "SI" o "NO".',
            'etnia_id.required' => 'El campo etnia es obligatorio.',
            'etnia_id.numeric' => 'El campo etnia debe ser un número.',
            'discapacidad_id.required' => 'El campo discapacidad es obligatorio.',
            'discapacidad_id.numeric' => 'El campo discapacidad debe ser un número.',
            'discapacidad_id.exists' => 'La discapacidad seleccionada no existe.',
            'etnia_id.exists' => 'La etnia seleccionada no existe.',
        ];
    }

}
