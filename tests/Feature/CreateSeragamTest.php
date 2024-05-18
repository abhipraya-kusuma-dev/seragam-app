<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSeragamTest extends TestCase
{
<<<<<<< HEAD
  public function test_create()
  {
    $user = User::where('name', 'admgudang')->first();
=======
// public function test_create(){
//   $user = User::where('name', 'admgudang')->first();
>>>>>>> ff8d5ac8432f43cdb7da5b6c35af62d681b2f182

//     $this->actingAs($user);

<<<<<<< HEAD
    $response = $this->post('/gudang/seragam/bikin/', [
      'nama_barang' => 'kemeja putih',
      'jenjang' => ['sd', 'smp', 'sma'],
      'jenis_kelamin' => 'cewe',
      'ukuran' => 'XL',
      'stok' => 4,
      'harga' => 1000
    ]);
=======
//     $response = $this->post('/gudang/seragam/bikin/',[
//       'nama_barang' => 'kemeja putih',
//         'jenjang' => 'SD',
//         'jenis_kelamin' => 'cewe',
//         'ukuran' => 'XL',
//         'stok' => 4,
//         'harga' => 1000
//     ]);
//     $response->assertSeeText('berhasil membuat seragam');
// }
>>>>>>> ff8d5ac8432f43cdb7da5b6c35af62d681b2f182

    $response->dd();
  }

  public function test_update()
  {
    $user = User::where('name', 'admgudang')->first();

    $this->actingAs($user);

    $response = $this->patch('/gudang/seragam/update/1', [
      'nama_barang' => 'kemeja putih',
<<<<<<< HEAD
      'jenjang' => 'SD',
      'jenis_kelamin' => 'cewe',
      'ukuran' => 'XL',
      'stok' => 4,
      'harga' => 1000
=======
        'jenjang' => ['sd', 'smp'],
        'jenis_kelamin' => ['cewe'],
        'ukuran' => 'XL',
        'stok' => 4,
        'harga' => 1000
>>>>>>> ff8d5ac8432f43cdb7da5b6c35af62d681b2f182
    ]);
    // $response->assertSeeText('berhasil update');
    $response->dd();
  }
<<<<<<< HEAD
  public function test_delete()
  {
    $user = User::where('name', 'admgudang')->first();
=======
  // public function test_delete(){
  //   $user = User::where('name', 'admgudang')->first();
>>>>>>> ff8d5ac8432f43cdb7da5b6c35af62d681b2f182

  //   $this->actingAs($user);

<<<<<<< HEAD
    $response = $this->delete('/gudang/seragam/delete/1');
    $response->assertSeeText('berhasil delete');
  }
=======
  //   $response = $this->delete('/gudang/seragam/delete/1');
  //   $response->assertSeeText('berhasil delete');
  // }
  
>>>>>>> ff8d5ac8432f43cdb7da5b6c35af62d681b2f182
}
