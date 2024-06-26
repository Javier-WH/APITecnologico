<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class validateUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType)
    {

        // Si el modo es "DEV", se desactiva la protección del token
        if (env('MODE') == 'DEV') {
            return $next($request);
        }

        // Obtener el payload del token JWT
        $payload = JWTAuth::parseToken()->getPayload();
        $payloadUserId = $payload->get('id');

        // Obtener el nivel del usuario desde la base de datos
        $user = User::find($payloadUserId);
        $userLevel = $user->level;

        // Validar el nivel de usuario según el tipo de usuario recibido
        if ($userType == 1) { // Validar para Administradores
            if ($userLevel != 1) {
                return jsonResponse(status:403, message: 'Acceso denegado', errors:['error' => 'No tiene permisos de administrador']);
            }
        } elseif ($userType == 2) { // Validar para Usuarios
            if ($userLevel == 3) {
                return jsonResponse(status: 403, message: 'Acceso denegado', errors: ['error' => 'No tiene permisos de usuario']);
            }
        } else {
            return jsonResponse(status: 403, message: 'Acceso denegado', errors: ['error' => 'Tipo de usuario inválido']);
        }

        // Validar si el usuario está intentando modificar su nivel de permisos
        if ($request->has('level') && $userLevel != 1) {
            return jsonResponse(status: 403, message: 'Acceso denegado', errors: ['error' => 'No tiene permisos para modificar el nivel de permisos']);
        }

        // Establecer el ID de usuario en el encabezado de la solicitud
        $request->headers->set('X-User-Id', $payloadUserId);

        return $next($request);
    }

}

