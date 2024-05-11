<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

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

    try {
      // TODO: logic bikin order baru

      return "Berhasil bikin order";
    } catch (Exception $e) {
      return "Gagal bikin order";
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
