<?php

namespace App\Helper;

class StringHelper
{
  public static function hargaIntToRupiah(int $harga)
  {
    $rupiah = number_format($harga, 0, ',', '.');

    return "Rp. $rupiah";
  }
}
