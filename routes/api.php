<?php

use App\Http\Controllers\UkurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Api as Ctr;

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

Route::get('/seragam', [UkurController::class, 'cariSeragam']);
Route::get('/laporan/lihat/', [LaporanController::class, 'filterOrderan']);

Route::get('/gudang/list-order', Ctr\GetGudangDataController::class)->name('api-gudang.list-order');
Route::get('/ukur/list-order', Ctr\GetUkurDataController::class)->name('api-ukur.list-order');
