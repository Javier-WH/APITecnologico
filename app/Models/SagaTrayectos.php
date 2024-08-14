<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaTrayectos extends Model
{
    use HasFactory;
    protected $table = "trayectos";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "trayecto",
        "user_id",
        "estatus",
        "char"
    ];
}
