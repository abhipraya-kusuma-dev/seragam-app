<?php

namespace App\Http\Controllers;

use App\Helper\StringHelper;
use App\Models\Seragam;
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

    return view('gudang.daftar-order', [
      'orders' => $orders,
      'title' => 'Gudang | Daftar Order'
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
      'order' => $order,
      'title' => 'Gudang | Order Detail'
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
              'status' => 'selesai',
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

      /*return back()->with('update-success', 'Berhasil mengubah data order!');*/
      return redirect('/gudang/order/')->with('update-success', 'Berhasil mengubah data order!');
    } catch (Exception $e) {
      DB::rollBack();
      return back()->with('update-error', $e->getMessage());
    }
  }

  public function daftarSeragam(Request $request)
  {
    $namaBarang = $request->query('nama_barang');
    $namaUkuran = $request->query('ukuran');
    $harga = $request->query('harga');
    $stok = $request->query('stok');

    $orderByNamaBarang = $request->query('orderBy', 'asc');
    $orderByTanggalOrder = $request->query('orderByTanggalOrder', 'asc');
    $orderByStok = $request->query('orderByStok', 'asc');
    $orderByHarga = $request->query('orderByHarga', 'asc');
    $orderByUkuran = $request->query('orderByUkuran', 'asc');

    $seragams = DB::table('seragams')
      ->select('id', 'nama_barang', 'jenjang', 'jenis_kelamin', 'ukuran', 'stok', 'harga', 'created_at')
      ->when($namaBarang, function (Builder $builder) use ($namaBarang) {
        return $builder->where('nama_barang', 'LIKE', "%$namaBarang%");
      })
      ->when($namaUkuran, function (Builder $builder) use ($namaUkuran) {
        return $builder->where('ukuran', $namaUkuran);
      })
      ->when($harga, function (Builder $builder) use ($harga) {
        return $builder->where('harga', 'LIKE', "%$harga%");
      })
      ->when($stok, function (Builder $builder) use ($stok) {
        return $builder->where('stok', $stok);
      })
      ->orderBy('created_at', $orderByTanggalOrder)
      ->orderBy('stok', $orderByStok)
      ->orderBy('harga', $orderByHarga)
      ->orderBy('ukuran', $orderByUkuran)
      ->orderBy('nama_barang', $orderByNamaBarang)
      ->get();

    $data = [];
    $pointer = 0;

    $list_ukuran_fix = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL', 'XXXXXL', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31', '33', '35', '37', '39', '41', 'universal'];

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

      $new_seragam = $seragams[$pointer];

      // If $seragams[$pointer]->nama_barang is completely new and didn't exists in $data array, then
      $data[] = [
        'id' => $new_seragam->id,
        'nama_barang' => $new_seragam->nama_barang,
        'jenjang' => $new_seragam->jenjang,
        'jenis_kelamin' => $new_seragam->jenis_kelamin,
        'ukuran' => $new_seragam->ukuran,
        'stok' => $new_seragam->stok,
        'harga' => StringHelper::hargaIntToRupiah($new_seragam->harga),
        'semua_ukuran' => [],
      ];

      foreach ($seragams as $seragam) {
        if ($new_seragam->nama_barang === $seragam->nama_barang && $new_seragam->id !== $seragam->id) {
          $data[count($data) - 1]['semua_ukuran'][] = [
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

    return view('gudang.daftar-seragam', [
      'data' => $data,
      'list_ukuran_fix' => $list_ukuran_fix,
      'title' => 'Gudang | Daftar Seragam'
    ]);
  }

  public function inputBikinSeragam(Request $request)
  {
    // TODO: Validasi data
  
    $validatedData = $request->validate([
      'jenjang.*' => 'required|in:sd,smp,sma,smk',
      'jenis_kelamin.*' => 'required|in:cowo,cewe',
      'nama_barang' => 'required',
      'ukuran' => 'required',
      'stok' => 'required|numeric|min:0',
      'harga' => 'required|numeric|min:1000'
    ]);

    
  

    try {
      // TODO: Create logic
      $validatedData['jenjang'] = implode(',', $validatedData['jenjang']);
      $validatedData['jenis_kelamin'] = implode(',', $validatedData['jenis_kelamin']);

      // NOTE: avoid duplicate data on create
      $seragam = Seragam::where('nama_barang', $validatedData['nama_barang'])->first();

      if ($seragam) {
        $isSameJenjang = $seragam->jenjang === $validatedData['jenjang'];
        $isSameJenisKelamin = $seragam->jenis_kelamin === $validatedData['jenis_kelamin'];
        $isSameUkuran = $seragam->ukuran === $validatedData['ukuran'];

        $isDuplicateData = $isSameJenjang && $isSameJenisKelamin && $isSameUkuran;

        if ($isDuplicateData) {
          throw new Exception('Gk bisa bikin data yang sama, Maksud kamu edit kah?');
        }
      }

      Seragam::create([
        'nama_barang' => $validatedData['nama_barang'],
        'jenjang' => $validatedData['jenjang'],
        'jenis_kelamin' => $validatedData['jenis_kelamin'],
        'ukuran' => $validatedData['ukuran'],
        'stok' => $validatedData['stok'],
        'harga' => $validatedData['harga']
      ]);

      // return "Berhasil membuat seragam!";
      return back()->with('create-success', "Berhasil membuat seragam!");
    } catch (Exception $e) {
      // return $e->getMessage();
      return back()->with('create-error', $e->getMessage());
    }
  }
  public function updateSeragam(Request $request, $id)
  {
    $validatedData = $request->validate([
      'jenjang.*' => 'required|in:sd,smp,sma,smk',
      'jenis_kelamin.*' => 'required|in:cowo,cewe',
      'nama_barang' => 'required',
      'ukuran' => 'required',
      'stok' => 'required|numeric|min:0',
      'harga' => 'required|numeric|min:1000'
    ]);

    try {
      $validatedData['jenjang'] = implode(',', $validatedData['jenjang']);
      $validatedData['jenis_kelamin'] = implode(',', $validatedData['jenis_kelamin']);

      Seragam::where('id', $id)->update($validatedData);
      return back()->with('update-success', 'Berhasil update');
    } catch (Exception $e) {
      return back()->with('update-error', 'Gagal update');
    }
  }
  public function deleteSeragam($id)
  {
    try {
      DB::table('seragams')
        ->where('id', $id)->delete();

      return back()->with('delete-success', 'Berhasil delete');
    } catch (Exception $e) {
      return back()->with('delete-error', 'Gagal delete');
    }
  }
}
