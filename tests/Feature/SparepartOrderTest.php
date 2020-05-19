<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class SparepartOrderTest extends TestCase
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

    public function test_order_success()
    {
       $data = [
        'user_id' => 2,
        'hull_code' => 111,
        'sparepart_id'=>1,
        'date' => Carbon::now(),
        'quantity' => '10',
        'type' => 'second',
        'unit_name' => 'pcs'
    ];

    $response = $this->post('/storespareparttest',$data);
    $response->assertStatus(200);
}

public function test_order_failed()
{
   $data = [
    'user_id' => 2,
    'hull_code' => null,
    'sparepart_id'=>1,
    'date' => Carbon::now(),
    'quantity' => '10',
    'type' => 'second',
    'unit_name' => 'pcs'
];

$response = $this->post('/storespareparttest',$data);
$response->assertStatus(500);

}



// $controller = new SparepartOrderController();
// $request = new Request($data);
// // dd($request->user_id);
// $response = $controller->order($request->user_id,$request->hull_code,$request->sparepart_id,$request->type,$request->date,$request->quantity,$request->unit_name);
// $this->assertJson('True', $response);

// // $this->assertJson('True');
// dd($response->headers->get('Location'));
// $this->assertEquals('http://localhost', $response->headers->get('Location'));
// $this->assertTrue($$response->headers);
}
