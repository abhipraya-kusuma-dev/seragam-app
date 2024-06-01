<?php

namespace App\Http\Controllers;

use App\Helper\StringHelper;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use App\Models\Status;
use Carbon\Carbon;
use Error;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UkurController extends Controller
{
  public function cariSeragam(Request $request)
  {
    $search = $request->query('search');

    $seragams = DB::table('seragams')
      ->whereRaw('LOWER(nama_barang) LIKE ?', ["%$search%"])
      ->select('id', 'nama_barang', 'jenjang', 'jenis_kelamin', 'ukuran', 'stok', 'harga')
      ->get();

    $data = [];
    $pointer = 0;

    while ($seragams->count() > $pointer) {
      $isExists = false;

      // Check duplicate entries for $seragams[$pointer]->nama_barang on $data array
      foreach ($data as $d) {
        if ($d['nama_barang'] === $seragams[$pointer]->nama_barang) {
          $isExists = true;

          break;
        }
      }

      // Skip the loop so $data array wouldn't have a new $seragam
      if ($isExists) {
        $pointer += 1;

        continue;
      };

      // If $seragams[$pointer]->nama_barang is completely new and didn't exists in $data array, then
      $data[] = [
        'id' => $seragams[$pointer]->id,
        'nama_barang' => $seragams[$pointer]->nama_barang,
        'jenjang' => $seragams[$pointer]->jenjang,
        'jenis_kelamin' => $seragams[$pointer]->jenis_kelamin,
        'ukuran' => $seragams[$pointer]->ukuran,
        'stok' => $seragams[$pointer]->stok,
        'harga' => StringHelper::hargaIntToRupiah($seragams[$pointer]->harga),
        'semua_ukuran' => [],
      ];

      foreach ($seragams as $seragam) {
        if ($seragams[$pointer]->nama_barang === $seragam->nama_barang && $seragams[$pointer]->id !== $seragam->id) {
          $data[$pointer]['semua_ukuran'][] = [
            'id' => $seragam->id,
            'nama_barang' => $seragam->nama_barang,
            'jenjang' => $seragam->jenjang,
            'jenis_kelamin' => $seragam->jenis_kelamin,
            'ukuran' => $seragam->ukuran,
            'stok' => $seragam->stok,
            'harga' => StringHelper::hargaIntToRupiah($seragam->harga),
          ];
        }
      }

      $pointer += 1;
    }

    return response()->json([
      'orders' => $data,
    ], 200);
  }

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
      ->select('id', 'nomor_urut', 'jenjang', 'nama_lengkap', 'created_at as order_masuk')
      ->get();

    foreach ($orders as $order) {
      $order->order_masuk = Carbon::parse($order->order_masuk)
        ->setTimezone('Asia/Jakarta')
        ->format('d/m/y | h:m');
    }

    return view('ukur.daftar-order', [
      'orders' => $orders,
      'title' => 'Ukur | Daftar Order'
    ]);
  }


  public function lihatOrderanMasuk($nomor_urut)
  {
    $order = DB::table('orders')
      ->where('nomor_urut', $nomor_urut)
      ->select('id', 'jenjang', 'nomor_urut', 'nama_lengkap')
      ->first();

    $semua_seragam = DB::table('statuses')
      ->join('seragams', 'seragams.id', 'statuses.seragam_id')
      ->where('statuses.order_id', $order->id)
      ->select('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'statuses.kuantitas')
      ->get();

    $order->semua_seragam = $semua_seragam;

    return view('ukur.order-detail', [
      'nomor_urut' => $nomor_urut,
      'order' => $order,
      'title' => 'Ukur | Order Detail'
    ]);
  }

  public function bikinOrder()
  {
    $lastOrder = Order::orderBy('nomor_urut', 'desc')->first();
    $lastOrderNum = (int) substr($lastOrder->nomor_urut, 1);

    $lastOrderNum += 1;

    $latestOrderNum = str_pad($lastOrderNum, 4, '0', STR_PAD_LEFT);

    return view('ukur.bikin-order', [
      'nomorOrderTerakhir' => $latestOrderNum,
      'title' => 'Ukur | Bikin Order'
    ]);
  }

  public function inputBikinOrder(Request $request)
  {
    // TODO: validasi data order
    $validatedData = $request->validate([
      'jenjang' => 'required|in:sd,smp,sma,smk',
      'nomor_urut' => 'required',
      'nama_lengkap' => 'required|min:3',
      'jenis_kelamin' => 'required|in:cowo,cewe',
      'seragam_id.*' => 'required|numeric|exists:seragams,id',
      'qty.*' => 'required|numeric|min:1'
    ]);

    try {
      // TODO: logic bikin order baru
      DB::beginTransaction();

      switch ($request->input('action')) {
        case 'complete':
          $order = Order::create([
            'jenjang' => $validatedData['jenjang'],
            'nomor_urut' => $validatedData['nomor_urut'],
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'status' => 'on-process',
          ]);

          break;
        case 'draft':
          $order = Order::create([
            'jenjang' => $validatedData['jenjang'],
            'nomor_urut' => $validatedData['nomor_urut'],
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'status' => 'draft',
          ]);

          break;
        default:
          throw new Error('Action nya salah');
          break;
      }

      foreach ($validatedData['seragam_id'] as $index => $id) {
        Status::create([
          'seragam_id' => $id,
          'order_id' => $order->id,
          'kuantitas' => $validatedData['qty'][$index]
        ]);
      }

      DB::commit();

      // return "Berhasil bikin order";
      return back()->with('create-success', 'Berhasil bikin order');
    } catch (Exception $e) {
      DB::rollBack();

      return "Gagal bikin order:" . $e->getMessage();
      // return back()->with('create-error', 'Gagal bikin order ' . $e->getMessage());
    }
  }

  public function editOrder($nomor_urut)
  {
    $order = DB::table('orders')
      ->where('nomor_urut', $nomor_urut)
      ->select('id', 'jenjang', 'nomor_urut', 'nama_lengkap', 'jenis_kelamin')
      ->first();

    $semua_seragam = DB::table('statuses')
      ->join('seragams', 'seragams.id', 'statuses.seragam_id')
      ->where('statuses.order_id', $order->id)
      ->select('seragams.id', 'seragams.nama_barang', 'seragams.ukuran', 'seragams.harga', 'statuses.kuantitas as QTY')
      ->get();

    foreach ($semua_seragam as $seragam) {
      $seragam->harga = StringHelper::hargaIntToRupiah($seragam->harga);
    }

    $order->semua_seragam = $semua_seragam;

    $lastOrderNum = (int) substr($nomor_urut, 1);

    $latestOrderNum = str_pad($lastOrderNum, 4, '0', STR_PAD_LEFT);

    return view('ukur.edit-order', [
      'order' => $order,
      'nomorOrderTerakhir' => $latestOrderNum,
      'title' => 'Ukur | Edit Order'
    ]);
  }

  public function updateOrder(Request $request, $id)
  {
    // TODO: validasi data order
    $validatedData = $request->validate([
      'jenjang' => 'required|in:sd,smp,sma,smk',
      'nomor_urut' => 'required',
      'nama_lengkap' => 'required|min:3',
      'jenis_kelamin' => 'required|in:cowo,cewe',
      'seragam_id.*' => 'required|numeric|exists:seragams,id',
      'qty.*' => 'required|numeric|min:1'
    ]);


    try {
      // TODO: logic update order
      DB::beginTransaction();

      $order = Order::findOrFail($id);

      $order->jenjang = $validatedData['jenjang'];
      $order->nomor_urut = $validatedData['nomor_urut'];
      $order->nama_lengkap = $validatedData['nama_lengkap'];
      $order->jenis_kelamin = $validatedData['jenis_kelamin'];

      $order->save();

      $orderID = Status::where('order_id', $id)->get()->pluck('seragam_id');
      $compare = $orderID->diff($validatedData['seragam_id']);

      Status::where('order_id', $id)->whereIn('seragam_id', $compare)->delete();

      foreach ($validatedData['seragam_id'] as $index => $seragamId) {
        Status::where('order_id', $id)->updateOrCreate(
          [
            'seragam_id' => $seragamId,
            'order_id' => $id
          ],
          [
            'kuantitas' => $validatedData['qty'][$index]
          ]
        );
      }

      DB::commit();

      // return 'Berhasil update order';
      return back()->with('update-success', 'Berhasil update order');
    } catch (Exception $e) {
      DB::rollBack();
      return 'Gagal update order' . $e->getMessage();
      // return back()->with('update-error', 'Gagal update order');
    }
  }

  public function deleteOrder($id)
  {
    try {
      $order = DB::table('orders')->where('id', $id);
      $order->delete();

      // return 'Berhasil hapus order';
      return back()->with('delete-success', 'Berhasil hapus order');
    } catch (Exception $e) {
      // return 'Gagal hapus order' . $e->getMessage();
      return back()->with('delete-error', 'Gagal hapus order' . $e->getMessage());
    }
  }
}
