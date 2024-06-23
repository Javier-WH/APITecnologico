<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaUser extends Model
{
    use HasFactory;
    protected $table = 'users';

    protected $fillable = [
        'id',
        'ci',
        'nac',
        'name',
        'surname',
        'username',
        'role',
        'group_id',
        'tlf1',
        'tlf2',
        'tlf3',
        'email1',
        'email2',
        'dir',
        'user_id',
        'estatus'
    ];
}
