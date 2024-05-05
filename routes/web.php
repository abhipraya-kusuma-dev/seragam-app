<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\UkurController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Gate;
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

Route::get('/redirect', function () {
  if (Gate::allows('read-gudang')) {
    return redirect('/gudang');
  }

  if (Gate::allows('read-ukur')) {
    return redirect('/ukur');
  }
})->middleware('auth');

Route::controller(UserController::class)->group(function () {
  Route::get('/login', 'login')->middleware('guest')->name('login');

  Route::post('/login', 'authenticate')->middleware('guest');
  Route::post('/logout', 'logout')->middleware('auth');
});

Route::controller(GudangController::class)->middleware('auth')->prefix('gudang')->group(function () {
  Route::get('/order', 'daftarOrder')->can('read-gudang');
  Route::get('/{nomor_urut}', 'lihatOrderanMasuk')->can('read-gudang');
  Route::put('/{nomor_urut}/update', 'updateOrderanMasuk')->can('update-gudang');

  Route::get('/seragam', 'daftarSeragam')->can('read-gudang');

  Route::get('/seragam/bikin', 'bikinSeragam')->can('create-gudang');
  Route::post('/seragam/bikin', 'inputBikinStokSeragam')->can('create-gudang');
});

Route::controller(UkurController::class)->middleware('auth')->prefix('ukur')->group(function () {
  Route::get('/', 'index')->can('read-ukur');
  Route::get('/{nomor_urut}', 'lihatOrderanMasuk')->can('read-ukur');
  Route::get('/bikin', 'inputUkurSeragam')->can('create-ukur');
});
