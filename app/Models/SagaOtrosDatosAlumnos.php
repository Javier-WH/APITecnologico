<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaOtrosDatosAlumnos extends Model
{
    use HasFactory;
    protected $table = "otros_datos_alumnos";
    public $timestamps = false;

    protected $fillable = [
        "CedulaAlumno",
        "LapsoIngreso",
        "LapsoActual",
        "trayecto_id",
        "turno_id",
        "programa_id",
        "PUNTAJE",
        "UCRCUR",
        "IAA",
        "CREDITOS_APROBADOS",
        "LapsoEgreso",
        "Estatus",
        "CondicionIngreso",
        "Seccion",
        "Repitiente",
        "LapsoAnterior",
        "TrayectoAnterior",
        "TurnoAnterior",
        "SeccionAnterior",
        "Cohorte",
        "elTurno",
        "UC_Aplazadas",
        "alumno_id",
        "estatusalumno_id",
        "gradoinstruccion_id",
        "condicioningreso_id",
        "id",
        "pensum_id",
        "lapso_id",
        "provieneinstitucion",
        "fechaegresoinstitucion",
        "tienerusnies",
        "esrusnies",
        "snirusnies",
        "semestre",
        "opcion",
        "lapsoingreso_id",
        "user_id",
        "mencion_id",
        "IAA_TSU"
    ];
}
