<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UkurSeragamTest extends TestCase
{
  public function test_update_order()
  {
    $userUkur = User::where('name', 'admukur')->first();

    $this->actingAs($userUkur);

    $response = $this->patch('/ukur/update/1', [
      'nomor_urut' => 'P980',
      'jenjang' => 'smp',
      'nama_lengkap' => 'John Doe',
      'jenis_kelamin' => 'cowo',
      'seragam_id' => [1, 3],
      'qty' => [2, 1]
    ]);

    $response->dd();
  }
}
