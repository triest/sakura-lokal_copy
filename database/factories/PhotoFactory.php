<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Photo::class, function (Faker $faker) {
    return [
        //
        'photo_name' => "test_name.jpg",
        'girl_id'    => $faker->randomDigit($min = 1,
            $max = 52),
    ];
});
