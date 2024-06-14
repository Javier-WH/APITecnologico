<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::post('/login', [LoginController::class, 'login']);

Route::prefix('user')->middleware('validateToken')->group(function () {
  Route::get('/', [RegisterController::class, 'show']);
  Route::post('/', [RegisterController::class, 'store']);
  Route::put('/', [RegisterController::class, 'update']);
  Route::delete('/', function () {
    return "ok delete";
  });
});