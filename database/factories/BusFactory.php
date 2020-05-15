<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Bus;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Bus::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'brand' => $faker->name,
        'type' => 'regular',
        'police_number '=> 'N 1543 ND',
        'license_date' => Carbon::now()
    ];
});
