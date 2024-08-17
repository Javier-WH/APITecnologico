<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaInscriptions extends Model
{
    use HasFactory;
    protected $table = "inscripcions";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "CODIGOMAT",
        "CEDULA",
        "nota",
        "recup",
        "programa_id",
        "user_id",
        "estatus",
        "uc_id",
        "lapso_id",
        "Seccion",
        "acreditable_id",
        "turno_id",
        "estatusalumno_id",
        "alumno_id"
    ];
    public function programas()
    {
        return $this->belongsTo(SagaProgramas::class, 'programa_id');
    }
}
