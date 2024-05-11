<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class UkurController extends Controller
{
  public function daftarOrder()
  {
    return view('ukur.daftar-order', [
      'orders' => []
    ]);
  }

  public function lihatOrderanMasuk($nomor_urut)
  {
    return view('ukur.order-detail', [
      'nomor_urut' => $nomor_urut,
      'order' => []
    ]);
  }

  public function bikinOrder()
  {
    return view('ukur.bikin-order', [
      'nomor-order-terakhir' => 00001
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

      $order = Order::create([
      'jenjang' => $validatedData['jenjang'],
      'nomor_urut' => $validatedData['nomor_urut'],
      'nama_lengkap' => $validatedData['nama_lengkap'],
      'jenis_kelamin' => $validatedData['jenis_kelamin'],
        ]);
        foreach($validatedData['seragam_id'] as $index => $id){
          Status::create([
            'seragam_id' => $id,
           'order_id' => $order->id,
           'kuantitas' => $validatedData['qty'][$index]
          ]); 
        }
        DB::commit();
      return "Berhasil bikin order";
    } catch (Exception $e) {
      DB::rollBack();
      return "Gagal bikin order:".$e->getMessage();
    }
  }

  public function editOrder($nomor_urut)
  {
    return view('ukur.edit-order', [
      'order' => []
    ]);
  }

  public function updateOrder(Request $request, $nomor_urut)
  {
    // TODO: validasi data order

    try {
      // TODO: logic update order

      return 'Berhasil update order';
    } catch (Exception $e) {
      return 'Gagal update order';
    }
  }

  public function deleteOrder($nomor_urut)
  {
    try {

      return 'Berhasil hapus order';
    } catch (Exception $e) {
      return 'Gagal hapus order';
    }
  }
}
