<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\NotificationController;

Route::post('/register', [RegistroController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'show']);
    Route::put('/usuario/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy']);
    Route::post('/usuario/avatar', [UsuarioController::class, 'updateAvatar']);
    Route::get('/usuario/recommended', [UsuarioController::class, 'recommended']);
    Route::post('/usuario/filter', [UsuarioController::class, 'filter']);
    Route::post('/notifications/send', [NotificationController::class, 'sendConnectionRequest']);
    Route::post('/notifications/respond/{id}', [NotificationController::class, 'respondToRequest']);
    Route::get('/notifications/pending', [NotificationController::class, 'getPendingNotifications']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification']);
    Route::get('/usuario/{username}', [UsuarioController::class, 'getUserByUsername']);
    Route::put('/notifications/{id}/accept', [NotificationController::class, 'accept']);
});

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);
