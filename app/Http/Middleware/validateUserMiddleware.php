<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class validateUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //Si MODE es igual a DEV, se desactiva la proteccion del token
        if (env('MODE') == 'DEV') {
            return $next($request);
        };

        //se valida el token
        $payload = JWTAuth::parseToken()->getPayload();
        $payloadUserId = $payload->get('id');
        //se obtiene el nivel del usario de la base de datos
        $userLevel = User::find($payloadUserId)->level;

        //un usuario de tipo 2 no puede modificar su nivel
        if($request->has("level") && $userLevel == 2){
            return jsonResponse(status: 403, message: "Acceso denegado", errors: ["error" => "No tiene permisos para modificar el nivel de permisos"]);
        }

        //valida por segunda vez el nivel y el id del usuario
        $isValidUser = validadateLevel($payload, $userLevel);
        if (!$isValidUser) {
            return jsonResponse(status: 403, message: "Acceso denegado", errors: ["error" => "No tiene permisos para realizar esta accion"]);
        }

        //se obtiene el id para usarlo en los endpoints, por ejemplo para inscribir alumnos
        $request->headers->set('X-User-Id', $payloadUserId);

        return $next($request);
    }
}

