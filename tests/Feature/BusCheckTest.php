<?php

namespace Tests\Feature;

use App\Http\Controllers\BusCheckingController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BusCheckTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_bus_check_success()
    {
        $data = [
            'user_id' => 4,
            'hull_code' => 111,
            'complaint' => 'Ada kerusakan di bus tolong di cek',
            'date' => Carbon::now()
        ];
        $response = $this->post('/storebuscheck',$data);
        $response->assertStatus(200);
        $response->assertJson(['Berhasil membuat pengecekan bus']);
    }
    public function test_bus_check_failed()
    {
        $data = [
            'user_id' => 4,
            'hull_code' => null,
            'complaint' => 'Ada kerusakan di bus tolong di cek',
            'date' => Carbon::now()
        ];
        $response = $this->post('/storebuscheck',$data);
        $response->assertStatus(500);
        $response->assertJson(['Gagal membuat pengecekan bus']);
       
    }
}
