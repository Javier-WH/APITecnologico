<?php

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api/v1',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'validateToken' => \App\Http\Middleware\validateTokenMiddleware::class,
            'validateUser' => \App\Http\Middleware\validateUserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //excepciones de validacion
        $exceptions->render(function (ValidationException $throwable) {
            return jsonResponse(status: $throwable->status, message: $throwable->getMessage(), errors: $throwable->errors());
        });

        //excepciones en general
        $exceptions->render(function (Exception $e) {
            Log::channel('general_errors')->error(PHP_EOL .'Excepción: ' . $e);
            return jsonResponse(status: 500, message: 'Ocurrió un error en el servidor', errors: [$e->getMessage()]);
        });
    })->create();
