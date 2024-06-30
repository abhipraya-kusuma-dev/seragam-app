<?php

namespace App\Imports;

use App\Models\Seragam;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SeragamImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    $row['jenjang'] = strtolower($row['jenjang']);
    $row['ukuran'] = strtoupper($row['ukuran']);
    $row['jenis_kelamin'] = strtolower($row['jenis_kelamin']);

    $data = [
      'stok' => $row['stok_awal'],
      'harga' => $row['harga'],
    ];

    Seragam::updateOrCreate([
      'nama_barang' => $row['nama_barang'],
      'jenjang' => $row['jenjang'],
      'ukuran' => $row['ukuran'],
      'jenis_kelamin' => $row['jenis_kelamin'],
    ], $data);
  }
}
