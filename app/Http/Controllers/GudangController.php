<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GudangController extends Controller
{
  public function index()
  {
    return view('gudang.index');
  }

  public function lihatOrderanMasuk($nomor_urut)
  {
    return view('gudang.order-detail', [
      'nomor_urut' => $nomor_urut
    ]);
  }

  public function inputStokSeragam()
  {
    return view('gudang.create');
  }
}
