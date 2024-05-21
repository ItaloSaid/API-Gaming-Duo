<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;

Route::post('/register', [RegistroController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);