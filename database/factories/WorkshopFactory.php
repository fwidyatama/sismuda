<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models;
use Carbon\Carbon;
use App\Models\Workshop;
use Faker\Generator as Faker;

$factory->define(Workshop::class, function (Faker $faker) {
    return [
        'hull_code' => 112,
        'user_id' => 2,
        'order_date' => Carbon::now(),
        'workshop_number'=>5,
        'note' => 'Ada kerusakan radio di bus',
        'work_type' => 'Kelistrikan'
    ];
});
