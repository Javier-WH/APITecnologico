<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $credentials = request(['user', 'password']);

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
