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
    $response = $this->patch('/ukur/update/1',[
        'jenjang' => 'smp',
        'nomor_urut' => 'P980',
        'nama_lengkap' => 'john doe',
        'jenis_kelamin' => 'cowo',
        'seragam_id' => [1, 2],
        'qty' => [100, 200]
    ]);
    $response->dd();
    }
    // public function test_delete(){
    //     $user = User::where('name', 'admukur')->first();

    // $this->actingAs($user);

    // $response = $this->delete('/ukur/delete/3');
    // $response->dd();
    // }

}
