<?php

use App\Http\Controllers\ApiUserInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SagaStudentController;
use App\Constants\Level;


/**
 * Rutas del api
 */

//ruta de health
Route::get('/health', function () {
    return 'Api operativa';
});

//login
Route::post('/login', [LoginController::class, 'login']);

//rutas de usuario del api
Route::prefix('user')->middleware('validateToken')->group(function () {

    Route::middleware('validateUser:' . Level::ADMIN)->group(function () {
        Route::post('/', [RegisterController::class, 'store']);
        Route::delete('/', [RegisterController::class, 'delete']);
    });

    Route::middleware('validateUser:' . Level::USER)->group(function () {
        Route::get('/', [RegisterController::class, 'show']);
        Route::put('/', [RegisterController::class, 'update']);
        Route::patch('/', [RegisterController::class, 'updatePartial']);

        Route::prefix('info')->group(function () {
            Route::get('/', [ApiUserInfoController::class, 'setUserInfo']);
            Route::patch('/', [ApiUserInfoController::class, 'updateInfo']);
        });
    });
});


//rutas de estudiantes del sistema SAGA
Route::prefix('student')->middleware('validateToken')->group(function () {
    Route::get('/', [SagaStudentController::class, 'getStudent']);

    Route::middleware('validateUser:' . Level::USER)->group(function () {
        Route::post('/', [SagaStudentController::class, 'addStudent']);
        Route::delete('/', [SagaStudentController::class, 'deleteStudent']);
        Route::put('/', [SagaStudentController::class, 'updateStudent']);
    });
});
