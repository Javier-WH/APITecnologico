<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class validateAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $isValidUser = validadateLevel($payload, 1);
        if(!$isValidUser){
            return jsonResponse(status: 403, message: "Acceso denegado", errors: ["error" => "No tiene permisos para realizar esta accion"]);
        }
        return $next($request);
    }
}
