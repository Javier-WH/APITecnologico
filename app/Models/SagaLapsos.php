<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaLapsos extends Model
{
    use HasFactory;
    protected $table = "inscripcions";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "Orden",
        "PeriodoAcademico",
        "ReferenciaLapso",
        "FechaInicial",
        "FechaFinal",
        "Observacion",
        "CodigoOperador",
        "FechaCreacion",
        "HoraCreacion",
        "EstatusRegistro",
        "Flag",
        "TipoLapso",
        "estatus",
        "inicio_lapso",
        "fin_inscripciones",
        "inicio_reingresos",
        "fin_reingresos",
        "inicio_traslados",
        "fin_traslados",
        "inicio_cambios",
        "fin_cambios",
        "rangonota_id",
        "tipolapso_id",
        "inicio_clases",
        "inicio_carga_notas",
        "fin_carga_notas",
        "inicio_congelacion",
        "fin_congelacion",
        "fecha_cierre"
    ];
}
