<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
  public function lihatOrderan(Request $request)
  {

    $tanggal = $request->tanggal;
    $jenjang = $request->jenjang;

    $orders = DB::table('seragams')
      ->join('statuses', 'seragams.id', '=', 'statuses.seragam_id')
      ->join('orders', 'orders.id', '=', 'statuses.order_id')
      ->when($tanggal, function (Builder $builder) use ($tanggal) {
        return $builder->whereDate('orders.created_at', '=', Carbon::parse($tanggal));
      })
      ->when($jenjang, function (Builder $builder) use ($jenjang) {
        return $builder->where('seragams.jenjang', 'LIKE', "%$jenjang%");
      })
      ->select('seragams.nama_barang', 'seragams.ukuran', DB::raw('SUM(statuses.kuantitas) as QTY'), 'seragams.jenjang', 'seragams.id', 'seragams.harga', 'orders.created_at')
      ->groupBy('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'seragams.jenjang', 'seragams.harga', 'orders.created_at')
      ->get();


    foreach ($orders as $order) {
      $statuses = DB::table('statuses')
        ->select('seragam_id', 'kuantitas')
        ->get();

      foreach ($statuses as $status) {
        if ($order->id == $status->seragam_id) {
          $order->total_penjualan = $order->total_penjualan ?? 0;
          $order->total_penjualan = $order->total_penjualan + ($order->harga * $status->kuantitas);
        }
      }
    }

    $orders = $orders->unique('nama_barang');

    return view('laporan.stok', [
      'orders' => $orders
    ]);
  }
  public function lihatKeuangan(Request $request)
  {

    $tanggal = $request->tanggal;
    $jenjang = $request->jenjang;

    $orders = DB::table('seragams')
      ->join('statuses', 'seragams.id', '=', 'statuses.seragam_id')
      ->join('orders', 'orders.id', '=', 'statuses.order_id')
      ->when($tanggal, function (Builder $builder) use ($tanggal) {
        return $builder->whereDate('orders.created_at', '=', Carbon::parse($tanggal));
      })
      ->when($jenjang, function (Builder $builder) use ($jenjang) {
        return $builder->where('seragams.jenjang', 'LIKE', "%$jenjang%");
      })
      ->select('seragams.nama_barang', 'seragams.ukuran', DB::raw('SUM(statuses.kuantitas) as QTY'), 'seragams.jenjang', 'seragams.id', 'seragams.harga', 'orders.created_at')
      ->groupBy('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'seragams.jenjang', 'seragams.harga', 'orders.created_at')
      ->get();


    foreach ($orders as $order) {
      $statuses = DB::table('statuses')
        ->select('seragam_id', 'kuantitas')
        ->get();

      foreach ($statuses as $status) {
        if ($order->id == $status->seragam_id) {
          $order->total_penjualan = $order->total_penjualan ?? 0;
          $order->total_penjualan = $order->total_penjualan + ($order->harga * $status->kuantitas);
        }
      }
    }

    $orders = $orders->unique('nama_barang');

    return view('laporan.stok', [
      'orders' => $orders
    ]);
  }
  public function export(Request $request)
  {
    $tanggal = $request->tanggal;
    $jenjang = $request->jenjang;

    return Excel::download(new LaporanExport($jenjang, $tanggal), 'Laporan Order' . $tanggal . '.xlsx');
  }
}
