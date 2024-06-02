<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use App\Models\Seragam;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    User::create([
      'name' => 'admgudang',
      'role' => 'admin-gudang',
      'password' => bcrypt('pwadmgudang')
    ]);

    User::create([
      'name' => 'admukur',
      'role' => 'admin-ukur',
      'password' => bcrypt('pwadmukur')
    ]);

    Seragam::create([
      'nama_barang' => 'Celana Biru',
      'jenjang' => 'smp',
      'jenis_kelamin' => 'cowo',
      'ukuran' => 'XL',
      'stok' => 10, // NOTE: berkurang ketika order selesai
      'harga' => 100000,
    ]);

    Seragam::create([
      'nama_barang' => 'Celana Cream',
      'jenjang' => 'smp,smk,sma',
      'jenis_kelamin' => 'cowo',
      'ukuran' => 'XL',
      'stok' => 10, // NOTE: berkurang ketika order selesai
      'harga' => 120000,
    ]);

    Seragam::create([
      'nama_barang' => 'Baju Batik',
      'jenjang' => 'smp,smk,sma',
      'jenis_kelamin' => 'cowo',
      'ukuran' => 'XL',
      'stok' => 18, // NOTE: berkurang ketika order selesai
      'harga' => 130000,
    ]);

    Seragam::create([
      'nama_barang' => 'Celana Biru',
      'jenjang' => 'smp',
      'jenis_kelamin' => 'cowo',
      'ukuran' => 'M',
      'stok' => 17, // NOTE: berkurang ketika order selesai
      'harga' => 100000,
    ]);

    Seragam::create([
      'nama_barang' => 'Rok Biru',
      'jenjang' => 'smp',
      'jenis_kelamin' => 'cewe',
      'ukuran' => 'L',
      'stok' => 17, // NOTE: berkurang ketika order selesai
      'harga' => 100000,
    ]);

    Seragam::create([
      'nama_barang' => 'Topi Biru',
      'jenjang' => 'smp',
      'jenis_kelamin' => 'cewe,cowo',
      'ukuran' => 'L',
      'stok' => 17, // NOTE: berkurang ketika order selesai
      'harga' => 100000,
    ]);

    // NOTE: bisa order 2 baju kah per orang ?
    Order::create([
      'nomor_urut' => 'P000',
      'jenjang' => 'smp',
      'nama_lengkap' => 'John Doe',
      'jenis_kelamin' => 'cowo',
      'status' => 'draft',
    ]);

    Status::create([
      'seragam_id' => 1,
      'order_id' => 1,
      'kuantitas' => 2,
      'tersedia' => false
    ]);

    Status::create([
      'seragam_id' => 2,
      'order_id' => 1,
      'kuantitas' => 1,
      'tersedia' => false
    ]);

    Order::create([
      'nomor_urut' => 'P000',
      'jenjang' => 'smp',
      'nama_lengkap' => 'Yanto',
      'jenis_kelamin' => 'cowo',
      'status' => 'on-process',
    ]);

    Status::create([
      'seragam_id' => 1,
      'order_id' => 2,
      'kuantitas' => 1,
      'tersedia' => false
    ]);

    Status::create([
      'seragam_id' => 2,
      'order_id' => 2,
      'kuantitas' => 1,
      'tersedia' => false
    ]);

    Status::create([
      'seragam_id' => 3,
      'order_id' => 2,
      'kuantitas' => 2,
      'tersedia' => false
    ]);
  }
}
