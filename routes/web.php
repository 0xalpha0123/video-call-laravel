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

Route::group(['prefix' => 'home'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/', [App\Http\Controllers\HomeController::class, 'generateRoom'])->name('home.generate');
});

// Route::group(['prefix' => 'videochat'], function () {
//     Route::get('create/{reservation_id}', [App\Http\Controllers\VideoChatController::class, 'create'])->name('videochat.create');

//     Route::get('join/{reservation_id}', [App\Http\Controllers\VideoChatController::class, 'join'])->name('videochat.join');
// });

Route::group(['prefix' => 'ajax'], function () {
    Route::post('videochat/authentication',  [App\Http\Controllers\VideoChatController::class, 'authentication'])->name('ajax.videochat.authentication');
});

Route::get('{reservation_id}', [App\Http\Controllers\VideoChatController::class, 'joinRoom'])->name('room.join');