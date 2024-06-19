<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class validateTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //Si MODE es igual a DEV, se desactiva la proteccion del token
        if (env('MODE') == 'DEV') {
            return $next($request);
        };


        try {
            JWTAuth::parseToken()->authenticate();
            //JWTAuth::parseToken()->getPayload();
            return $next($request);
        } catch (TokenExpiredException $e) {
            return jsonResponse(status: 401, message: "Debe iniciar sesion de nuevo", errors: ["error" => "Token expirado"]);
        } catch (JWTException $e) {
            return jsonResponse(status: 403, message: "Acceso denegado", errors: ["error" => "No tiene permisos para realizar esta accion"]);
        }

    }
}
