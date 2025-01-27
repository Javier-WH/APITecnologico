<?php

use App\Http\Controllers\ApiUserInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SagaStudentController;
use App\Constants\Level;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SagaProfesorController;

/**
 * Rutas del api
 */

//ruta de health
Route::get('/health', function () {
    return 'Api operativa';
});

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
        Route::get('/inscription', [InscriptionController::class, 'Inscriptions']);
        Route::post('/', [SagaStudentController::class, 'addStudent']);
        Route::delete('/', [SagaStudentController::class, 'deleteStudent']);
        Route::put('/', [SagaStudentController::class, 'updateStudent']);
    });
});

Route::middleware(['validateToken', 'validateUser:' . Level::ADMIN])->group(function () {
    Route::get('/ucslist', [InscriptionController::class, 'ucs']);
    Route::get('/prelations', [InscriptionController::class, 'prelations']);
    Route::get('/programas', [InscriptionController::class, 'programas']);
    Route::get('/trayectos', [InscriptionController::class, 'trayectos']);
    Route::get('/turnos', [InscriptionController::class, 'turnos']);
    // profesores
    Route::get('/teachers', [SagaProfesorController::class, 'getTeachers']);
});
