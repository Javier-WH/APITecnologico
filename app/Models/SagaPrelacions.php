<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaPrelacions extends Model
{
    use HasFactory;
    protected $table = "prelacions";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "uc_id",
        "PreladaPor",
        "programa_id",
        "pensum_id",
        "user_id",
        "FechaCreacion",
        "HoraCreacion",
        "estatus"
    ];
}
