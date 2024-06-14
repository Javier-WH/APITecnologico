<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(CreateUserRequest $request)
    {
        User::create([
            'id' => Str::uuid(),
            'user' => $request->user,
            'password' => $request->password,
            'level' => $request->level,
        ]);
    }
}
