<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaAlumnos extends Model
{
    use HasFactory;
    protected $table = 'alumnos';

    protected $fillable = [
        'id',
        'cedulapasaporte',
        'nombre',
        'apellido',
        'nacionalidad_id',
        'sexo_id',
        'fechanacimiento',
        'lugarnacimiento',
        'direccion',
        'parroquia_id',
        'telefono1',
        'telefono2',
        'email1',
        'email2',
        'provieneinstitucion',
        'fechaegresoinstitucion',
        'tienerusnies',
        'esrusnies',
        'snirusnies',
        'semestre',
        'opcion',
        'esimpedido',
        'discapacidad_id',
        'dconsignados',
        'user_id',
        'etnia_id'
    ];
}
