<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaNacionalidadsModel extends Model
{
    use HasFactory;
    protected $table = 'nacionalidads';

    protected $fillable = [
        'id',
        'char',
        'des',
        'cat'
    ];
}
