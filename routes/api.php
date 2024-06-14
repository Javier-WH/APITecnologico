<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::post('/login', [LoginController::class, 'login']);

Route::post('/users', [RegisterController::class, 'store']);