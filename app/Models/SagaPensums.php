<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaPensums extends Model
{
    use HasFactory;
    protected $table = "pensums";
    public $timestamps = false;

    protected $fillable = [
        "id",
        "programa_id",
        "tipopensum_id",
        "descripcion",
        "nota",
        "user_id",
        "estatus",
        "ucr_tsu",
        "ucr_ing_lic"
    ];
}
