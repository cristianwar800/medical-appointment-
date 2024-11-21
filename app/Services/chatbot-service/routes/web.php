<?php

use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php
// routes/web.php
Route::middleware(['auth'])->group(function () {
   
});

Route::get('/chat', [ChatbotController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [ChatbotController::class, 'sendMessage'])->name('chat.send');
Route::post('/chat/validate', [ChatbotController::class, 'validateUser'])->name('chat.validate');
Route::get('/chat/check-session', [ChatbotController::class, 'checkSession'])->name('chat.check-session');