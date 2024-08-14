<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaUcs extends Model
{
    use HasFactory;
    protected $table = "ucs";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "descripcion",
        "ucr",
        "htea",
        "htei",
        "thte",
        "trayecto_id",
        "tipouc_id",
        "programa_id",
        "tiene_prerequisito",
        "user_id",
        "estatus"
    ];
}
