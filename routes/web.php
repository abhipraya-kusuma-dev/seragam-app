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
    return redirect('/gudang/order');
  }

  if (Gate::allows('read-ukur')) {
    return redirect('/ukur');
  }
})->middleware('auth');

Route::get('/', function () {
  return redirect('/redirect');
});

Route::controller(UserController::class)->group(function () {
  Route::get('/login', 'login')->middleware('guest')->name('login');

  Route::post('/login', 'authenticate')->middleware('guest');
  Route::post('/logout', 'logout')->middleware('auth');
});

Route::controller(GudangController::class)
  ->middleware('auth')
  ->prefix('gudang') // NOTE: Baca aku bro!
  ->group(function () {
    Route::get('/order', 'daftarOrder')->can('read-gudang');
    Route::get('/order/{nomor_urut}', 'lihatOrderanMasuk')->can('read-gudang');
    Route::put('/order/{nomor_urut}/update', 'updateOrderanMasuk')->can('update-gudang');

    Route::get('/seragam/bikin', 'daftarSeragam')->can('create-gudang');
    Route::post('/seragam/bikin', 'inputBikinSeragam')->can('create-gudang');
    Route::patch('/seragam/update/{id}', 'updateSeragam')->can('update-gudang');
    Route::delete('/seragam/delete/{id}', 'deleteSeragam')->can('delete-gudang');
  });

Route::controller(UkurController::class)->middleware('auth')->prefix('ukur')->group(function () {
  Route::get('/order', 'daftarOrder')->can('read-ukur');
  Route::get('/{nomor_urut}', 'lihatOrderanMasuk')->can('read-ukur');
  Route::post('/bikin', 'inputBikinOrder')->can('create-ukur');
});
