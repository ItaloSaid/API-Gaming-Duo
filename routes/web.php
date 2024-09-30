<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValorantController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::post('/notifications/send', [\App\Http\Controllers\NotificationController::class, 'sendConnectionRequest']);

Route::get('/valorant/{username}', [ValorantController::class, 'getValorantStats']);

require __DIR__ . '/auth.php';
