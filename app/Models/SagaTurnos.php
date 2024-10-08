<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaTurnos extends Model
{
    use HasFactory;
    protected $table = "turnos";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "turno",
        "user_id",
        "estatus",
        "char"
    ];
}
