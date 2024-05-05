<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class GudangController extends Controller
{
  public function daftarOrder()
  {
    return view('gudang.daftar-order');
  }

  public function lihatOrderanMasuk($nomor_urut)
  {
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
