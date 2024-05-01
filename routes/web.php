<?php

use App\Http\Controllers\UserController;
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

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::get('/beranda', function(){
    return view('beranda');
})->middleware('auth');

Route::post('/login', [UserController::class, 'login'])->middleware('guest');

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');

