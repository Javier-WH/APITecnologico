<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SagaStudentController;




/**
 * Rutas del api
 */

//ruta de health
Route::get('/health', function () {return 'Api operativa';});


//login
Route::post('/login', [LoginController::class, 'login']);

//rutas de usuario del api
Route::prefix('user')->middleware('validateToken')->group(function () {
  Route::post('/', [RegisterController::class, 'store'])->middleware('validateAdmin');
  Route::delete('/', [RegisterController::class, 'delete'])->middleware('validateAdmin');
  Route::get('/', [RegisterController::class, 'show'])->middleware('validateUser');
  Route::put('/', [RegisterController::class, 'update'])->middleware('validateUser');
});


//rutas de estudiantes del sistema SAGA
Route::prefix('student')->middleware('validateToken')->group( function () {
    Route::get('/', [SagaStudentController::class, 'getStudent']);
});
