<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaProgramas extends Model
{
    use HasFactory;
    protected $table = "programas";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "programa",
        "user_id",
        "estatus",
        "css",
        "largo",
        "grado",
        "char"
    ];
}
