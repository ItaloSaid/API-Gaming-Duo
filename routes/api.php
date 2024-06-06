<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;

Route::post('/register', [RegistroController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'show']);
    Route::put('/usuario/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy']);
    Route::post('/usuario/avatar', [UsuarioController::class, 'updateAvatar']);
    Route::get('/usuario/recommended', [UsuarioController::class, 'recommended']);  // Mudança aqui para GET
    Route::post('/usuario/filter', [UsuarioController::class, 'filter']);
});
