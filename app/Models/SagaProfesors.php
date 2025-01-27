<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaProfesors extends Model {
    use HasFactory;
    protected $table = "profesors";
    public $timestamps = false;

    protected $fillable = [
        'CedulaProfesor',
        'NombreProfesor',
        'ApellidoProfesor',
        'sexo',
        'DireccionProfesor',
        'FechaNacimiento',
        'programa_id',
        'RefAreaFormacion',
        'LugarNacimiento',
        'CodigoCiudad',
        'Telefonos',
        'Emails',
        'tipodoc_id',
        'dedicacion_id',
        'condicion_id',
        'Observaciones',
        'user_id',
        'estatus',
        'Nacionalidad',
        'tlfMovil',
        'tlfLocal',
        'tlfAdicional',
        'email1',
        'email2',
        'parroquia_id',
        'Foto',
        'pregrado',
        'postgrado',
        'especializacion',
        'maestria',
        'doctorado',
    ];
}
