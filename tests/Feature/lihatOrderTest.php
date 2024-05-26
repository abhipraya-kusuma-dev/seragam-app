<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class lihatOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_lihatOrder()
    {
        $user = User::where('name', 'admgudang')->first();
    $this->actingAs($user);

        $response = $this->get('/laporan/lihat');
        $response->dd();
    }
}
