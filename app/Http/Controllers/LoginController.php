<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = request(['user', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return jsonResponse(
                status: 401,
                message: 'Credenciales Invalidas',
                errors: ['unauthorized' => 'Credenciales Invalidas']
            );
        }

        //payload personalizado para el token
        $user = auth()->user();
        $payload = [
            'id' => $user->id,
            'user' => $user->user,
            'level' => $user->level,
        ];

        //crea el token
        $token = auth()->claims($payload)->attempt($credentials);


        return jsonResponse(data: [
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'id' => $user->id
        ]);
    }
}
