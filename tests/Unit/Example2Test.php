<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;

use Carbon\Carbon;

class Example2Test extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

  
    public function test_create() {

        // $this->withoutExceptionHandling();
        $this->withoutMiddleware();

         $data = [
            'hull_code' => 112,
            'user_id' => 2,
            'order_date' => Carbon::now(),
            'workshop_number'=>4,
            'note' => 'Ada kerusakan radio di bus',
            'work_type' => 'Kelistrikan'
        ];
    
       $response = $this->post('workshop/storeworkshop',$data);
        $response->assertJson(['Berhasil']);
    
        
    }
  
    
}
