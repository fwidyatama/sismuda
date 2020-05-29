<?php

namespace Tests\Feature;

use App\Http\Controllers\WorkshopController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\RedirectResponse;

class WorkshopTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_workshop_success()
    {
       $data = [
        'hull_code' => 111,
        'user_id' => 5,
        'order_date' => Carbon::now(),
        'workshop_number'=>3,
        'note' => 'Ada kerusakan di bus',
        'work_type' => 'kelistrikan',
    ];
   
    $response = $this->post('/storeworkshoptest',$data);
    $response->assertStatus(200);
    $response->assertJson(['Berhasil membuat surat tugas'],200);
}
public function test_workshop_fails()
{
   $data = [
    'hull_code' => null,
    'user_id' => 5,
    'order_date' => Carbon::now(),
    'workshop_number'=>3,
    'note' => 'Ada kerusakan di bus',
    'work_type' => 'kelistrikan',
];
$response = $this->post('/storeworkshoptest',$data);
$response->assertStatus(500);
$response->assertJson(['Gagal membuat surat tugas'],500);

}
}
