<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
  public function daftarOrder(Request $request)
  {
    $status = $request->query('status', 'on-process');

    $orders = DB::table('orders')
      ->where('status', $status)
      ->select('nomor_urut', 'jenjang', 'nama_lengkap', 'created_at as order_masuk')
      ->get();

    foreach ($orders as $order) {
      $order->order_masuk = Carbon::parse($order->order_masuk)
        ->timezone('Asia/Jakarta')
        ->format('d/m/y | h:m');
    }

    return view('gudang.daftar-order', $orders);
  }

  public function lihatOrderanMasuk($nomor_urut)
  {
    $order = DB::table('orders')
      ->join('statuses', 'statuses.order_id', 'orders.id')
      ->join('seragams', 'seragams.id', 'statuses.seragam_id')
      ->where('orders.id', $nomor_urut)
      ->first();

    return view('gudang.order-detail', [
      'nomor_urut' => $nomor_urut
    ]);
  }

  public function updateOrderanMasuk($nomor_urut, Request $request)
  {
    // TODO: Validasi data

    try {
      // TODO: Update logic

    } catch (Exception $e) {
      return back()->with('update-error', $e->getMessage());
    }
  }

  public function daftarSeragam()
  {
    return view('gudang.daftar-seragam');
  }

  public function bikinSeragam()
  {
    return view('gudang.bikin-seragam');
  }

  public function inputBikinSeragam(Request $request)
  {
    // TODO: Validasi data

    try {
      // TODO: Create logic

    } catch (Exception $e) {
      return back()->with('create-error', $e->getMessage());
    }
  }
}
