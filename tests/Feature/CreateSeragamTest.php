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

    $response = $this->post('/gudang/seragam/bikin/', [
        'nama_barang' => 'kemeja putih',
          'jenjang' => 'SD',
          'jenis_kelamin' => 'cowo',
          'ukuran' => 'S',
          'stok' => 4,
          'harga' => 1000
    ]);
    
    $response->assertSeeText('berhasil membuat seragam');
  }
}
