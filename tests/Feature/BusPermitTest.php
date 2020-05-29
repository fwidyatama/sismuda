<?php

namespace Tests\Feature;

use App\Http\Controllers\BusPermitController;
use App\Models\Workshop;
use Tests\TestCase;
use Carbon\Carbon;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\RedirectResponse;

class BusPermitTest extends TestCase
{

    // protected function setUp():void {
    //     $conn=$this->getConnection();
    //     $conn->getConnection()->query("set foreign_key_checks=0");
    //     parent::setUp();
    //      $conn->getConnection()->query("set foreign_key_checks=1");
    //  }
    use RefreshDatabase;
    // protected $workshops;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_permit_success()
    {
        $data = [
            'hull_code'=>123,
            'user_id' => 5,
            'date' => Carbon::now(),
            'workshop_number' => 3,
            'note' => "Tidak ada catatan",
        ];

        $response = $this->post('/storepermitunit',$data);
        $response->assertJson(['Berhasil menambah data']);
        $response->assertStatus(200);
    }
    
    public function test_permit_fails()
    {
        $data = [
            'hull_code'=>null,
            'user_id' => 5,
            'date' => Carbon::now(),
            'workshop_number' => 3,
            'note' => "Tidak ada catatan",
        ];

        $response = $this->post('/storepermitunit',$data);
        $response->assertJson(['Gagal menambah data']);
        $response->assertStatus(500);
    }
}
