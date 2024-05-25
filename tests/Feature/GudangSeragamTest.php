<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GudangSeragamTest extends TestCase
{
  // protected function setUp(): void
  // {
  //   parent::setUp();
  //   Artisan::call('migrate:fresh --seed');
  // }
  //
  // public function test_input_seragam()
  // {
  //   $userGudang = User::where('name', 'admgudang')->first();
  //
  //   $this->actingAs($userGudang);
  //
  //   $response = $this->post('/gudang/seragam/bikin', [
  //     'jenjang' => ['smp', 'sma', 'smk'],
  //     'jenis_kelamin' => ['cowo', 'cewe'],
  //     'nama_barang' => 'Bawahan Cream',
  //     'ukuran' => 'S',
  //     'stok' => 10,
  //     'harga' => 100000
  //   ]);
  //
  //   $response->dd();
  // }

  public function test_edit_input_seragam()
  {
    $userGudang = User::where('name', 'admgudang')->first();

    $this->actingAs($userGudang);

    $response = $this->patch('/gudang/seragam/update/5', [
      'jenjang' => ['smp', 'sma'],
      'jenis_kelamin' => ['cowo'],
      'nama_barang' => 'Bawahan Cream',
      'ukuran' => 'S',
      'stok' => 10,
      'harga' => 100000
    ]);

    $response->dd();
  }
}
