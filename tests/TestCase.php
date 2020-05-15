<?php

namespace Tests;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    // public function setUp():void
    // {
    //     // $conn=$this->getConnection();
    //     // $conn->getConnection()->query("set foreign_key_checks=0");
    //     parent::setUp();
    //     $this->prepareForTests();
    //     //  $conn->getConnection()->query("set foreign_key_checks=1");
    // }
 

    // private function prepareForTests()
    // {
    //     Artisan::call('migrate');
    //     // Mail::pretend(true);
    // }
    
   
}
