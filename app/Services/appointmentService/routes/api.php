<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/appointments', [AppointmentApiController::class, 'index']);
Route::post('/appointments', [AppointmentApiController::class, 'store']);
Route::get('/appointments/{appointment}', [AppointmentApiController::class, 'show']);
Route::put('/appointments/{appointment}', [AppointmentApiController::class, 'update']);
Route::delete('/appointments/{appointment}', [AppointmentApiController::class, 'destroy']);
Route::patch('/appointments/{appointment}/status', [AppointmentApiController::class, 'updateStatus']);