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
    return view('welcome');
});

Route::get('send-email/{to?}', [App\Http\Controllers\EmailController::class, 'index'])->name('send-email');
Route::get('display-user', [App\Http\Controllers\UserController::class, 'index']);
Route::post('location-send', [App\Http\Controllers\UserController::class, 'location_send'])->name('location-send');