<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSeragamTest extends TestCase
{
public function test_create(){
  $user = User::where('name', 'admgudang')->first();

    $this->actingAs($user);

    $response = $this->post('/gudang/seragam/bikin/',[
      'nama_barang' => 'kemeja putih',
        'jenjang' => 'SD',
        'jenis_kelamin' => 'cewe',
        'ukuran' => 'XL',
        'stok' => 4,
        'harga' => 1000
    ]);
    $response->assertSeeText('berhasil membuat seragam');
}

  public function test_update(){
    $user = User::where('name', 'admgudang')->first();

    $this->actingAs($user);

    $response = $this->patch('/gudang/seragam/update/1', [
      'nama_barang' => 'kemeja putih',
        'jenjang' => 'SD',
        'jenis_kelamin' => 'cewe',
        'ukuran' => 'XL',
        'stok' => 4,
        'harga' => 1000
    ]);
    $response->assertSeeText('berhasil update');
  }
  public function test_delete(){
    $user = User::where('name', 'admgudang')->first();

    $this->actingAs($user);

    $response = $this->delete('/gudang/seragam/delete/1');
    $response->assertSeeText('berhasil delete');
  }
  
}
