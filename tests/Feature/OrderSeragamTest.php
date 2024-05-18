<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class OrderSeragamTest extends TestCase
{
//     public function test_create(){
//         $user = User::where('name', 'admukur')->first();

//     $this->actingAs($user);

//     $response = $this->post('/ukur/bikin/',[
//         'jenjang' => 'sd',
//         'nomor_urut' => 'P90000',
//         'nama_lengkap' => 'Muhammad Fakhry Haidar',
//         'jenis_kelamin' => 'cowo',
//         'seragam_id' => [2, 3],
//         'qty' => [7, 9]
//     ]);
// $response->dd();
    
//     }
    public function test_update(){
        $user = User::where('name', 'admukur')->first();

    $this->actingAs($user);

    $response = $this->patch('/ukur/update/2',[
        'jenjang' => 'smp',
        'nomor_urut' => 'hi',
        'nama_lengkap' => 'William',
        'jenis_kelamin' => 'cowo',
        'seragam_id' => [2, 3],
        'qty' => [10, 11]
    ]);
    $response->dd();
    }
    // public function test_delete(){
    //     $user = User::where('name', 'admukur')->first();

    // $this->actingAs($user);

    // $response = $this->delete('/ukur/delete/2');
    // $response->dd();
    // }
}
