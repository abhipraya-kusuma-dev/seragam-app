<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UkurController extends Controller
{
  public function index()
  {
    return view('ukur.index');
  }

  public function lihatOrderanMasuk($nomor_urut)
  {
    return view('ukur.order-detail', [
      'nomor_urut' => $nomor_urut
    ]);
  }

  public function inputUkurSeragam()
  {
    return view('ukur.create');
  }
}
