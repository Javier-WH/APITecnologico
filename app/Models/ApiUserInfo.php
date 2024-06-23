<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUserInfo extends Model
{
    use HasFactory;
    protected $table = 'api_user_info';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'ci',
        'email',
        'phone',
        'address',
        'description'
    ];
}
