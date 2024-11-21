<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

Route::controller(ChatbotApiController::class)->group(function () {
    Route::get('/test', 'test');
    Route::post('/message', 'processMessage');
    Route::get('/appointments/pending', 'getPendingAppointments');
    Route::get('/agenda', 'getAgenda');
    Route::get('/stats', 'getStats');
    Route::get('/history/{sessionId?}', 'getChatHistory');
});