<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'            => $faker->firstNameFemale,
        'email'           => $faker->unique()->safeEmail,
        'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        // password
        /*   'remember_token'  => $faker->realText($maxNbChars = 10, $indexSize = 2),*/
        'money'           => $faker->numberBetween($min = 0, $max = 1000000),
        'phone'           => $faker->randomDigit($min = 10000000000,
            $max = 90000000000),
        'beginvip'        => $faker->dateTime(),
        'endvip'          => $faker->dateTime(),
        'is_admin'        => $faker->boolean(random_int(0, 1)),
        'active_code'     => $faker->boolean(random_int(0000, 9999)),
        'phone_confirmed' => 1,
    ];
});
