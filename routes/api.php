<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::post('/login', [LoginController::class, 'login']);

Route::get('/user', [RegisterController::class, 'show'])->middleware('validateToken');

Route::post('/user', [RegisterController::class, 'store']);

Route::put('/user', [RegisterController::class, 'update']);
