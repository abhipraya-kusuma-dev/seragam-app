<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetGudangDataController extends Controller
{
  public function __invoke(Request $request)
  {
    $search = $request->query('search');
    $status = $request->query('status');

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

    return response()->json([
      'orders' => $orders
    ]);
  }
}
