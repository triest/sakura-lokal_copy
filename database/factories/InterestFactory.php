<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Interest::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
    ];
});
