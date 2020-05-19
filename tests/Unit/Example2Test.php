<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

class Example2Test extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

  
    public function test_create() {

        $user = factory(User::class)->make([
            'id' => 2,
        ]);

        dd($user);
        
        
    }
  
    
}
