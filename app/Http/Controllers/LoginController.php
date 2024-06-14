<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return jsonResponse(
                status: 401,
                message: 'Credenciales Invalidas',
                errors: ['unauthorized' => 'Credenciales Invalidas']
            );
        }

        return jsonResponse(data: [
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
