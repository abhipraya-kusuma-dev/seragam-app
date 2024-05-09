<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
  public function daftarOrder(Request $request)
  {
    $search = $request->query('search');

    $status = $request->query('status', 'on-process');

    $orders = DB::table('orders')
      ->when($search, function (Builder $builder) use ($search) {
        $search = strtolower($search);

        return $builder
          ->whereRaw('LOWER(nomor_urut) like ?', ["%$search%"])
          ->orWhereRaw('LOWER(nama_lengkap) like ?', ["%$search%"]);
      })
      ->where('status', $status)
      ->select('nomor_urut', 'jenjang', 'nama_lengkap', 'created_at as order_masuk', 'complete_timestamp as order_keluar')
      ->get();

    foreach ($orders as $order) {
      $order->order_masuk = Carbon::parse($order->order_masuk)
        ->timezone('Asia/Jakarta')
        ->format('d/m/y | h:m');

      if ($order->order_keluar) {
        $order->order_keluar = Carbon::parse($order->order_keluar)
          ->timezone('Asia/Jakarta')
          ->format('d/m/y | h:m');
      }
    }

    dd($orders);

    return view('gudang.daftar-order', [
      'orders' => $orders
    ]);
  }

  public function lihatOrderanMasuk($nomor_urut)
  {
    $order = DB::table('orders')
      ->where('nomor_urut', $nomor_urut)
      ->first(['id', 'jenjang', 'nomor_urut', 'nama_lengkap']);

    $seragams = DB::table('orders')
      ->join('statuses', 'statuses.order_id', 'orders.id')
      ->join('seragams', 'seragams.id', 'statuses.seragam_id')
      ->where('orders.nomor_urut', $nomor_urut)
      ->select('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'statuses.tersedia', 'statuses.kuantitas')
      ->get();

    $order->seragams = $seragams;

    return view('gudang.order-detail', [
      'nomor_urut' => $nomor_urut,
      'order' => $order
    ]);
  }

  public function updateOrderanMasuk($nomor_urut, Request $request)
  {
    $validatedData = $request->validate([
      'seragam_ids.*' => 'sometimes|exists:seragams,id',
    ]);

    DB::beginTransaction();

    try {
      switch ($request->input('action')) {
        case 'draft':
          DB::table('orders')
            ->where('nomor_urut', $nomor_urut)
            ->update([
              'status' => 'draft'
            ]);
          break;
        case 'complete':
          DB::table('orders')
            ->where('nomor_urut', $nomor_urut)
            ->update([
              'complete_timestamp' => now(),
              'status' => 'complete',
            ]);
          break;
      }

      $seragams = DB::table('orders')
        ->join('statuses', 'statuses.order_id', 'orders.id')
        ->where('orders.nomor_urut', $nomor_urut)
        ->select('statuses.tersedia', 'statuses.seragam_id', 'statuses.order_id')
        ->get();

      $seragam_ids_input = $request->has('seragam_ids') ? $validatedData['seragam_ids'] : [];

      foreach ($seragams as $seragam) {
        DB::table('statuses')
          ->where('statuses.seragam_id', $seragam->seragam_id)
          ->where('statuses.order_id', $seragam->order_id)
          ->update([
            'statuses.tersedia' => (int)in_array($seragam->seragam_id, $seragam_ids_input)
          ]);
      }

      DB::commit();

      return back()->with('update-success', 'Berhasil mengubah data order!');
    } catch (Exception $e) {
      DB::rollBack();
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
