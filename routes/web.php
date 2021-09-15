<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('videochat/create/{reservation_id}', [App\Http\Controllers\VideoChatController::class, 'create'])->name('videochat.create');

Route::get('videochat/join/{reservation_id}', [App\Http\Controllers\VideoChatController::class, 'join'])->name('videochat.join');

Route::post('ajax/videochat/authentication', [App\Http\Controllers\VideoChatController::class, 'authentication'])->name('ajax.videochat.authentication');