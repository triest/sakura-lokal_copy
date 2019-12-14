<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Girl::class, function (Faker $faker) {
    return [
        //
        'name'  => $faker->name,
        'phone' => $faker->numberBetween($min = 100000000, $max = 90000000),

        'description' => $faker->text,
        'private'     => $faker->text,
        'sex'         => function () {
            $num = random_int(0, 1);
            if ($num == 0) {
                return 'famele';
            } else {
                return 'male';
            }
        },
        'age'         => $faker->numberBetween($min = 18,
            $max = 60),
        'weight'      => $faker->numberBetween($min = 45,
            $max = 80),
        'height'      => $faker->numberBetween($min = 145,
            $max = 180),
        'meet'        => function () {
            $num = random_int(0, 1);
            if ($num == 0) {
                return 'famele';
            } else {
                return 'male';
            }
        },
        'status'      => $faker->realText($maxNbChars = 100, $indexSize = 2),
        /*'phone_settings' => $faker->randomDigit($min = 1,
            $max = 2),*/
        'from_age'    => $faker->numberBetween($min = 18,
            $max = 60),
        'to_age'      => $faker->numberBetween($min = 18,
            $max = 60),
        /* 'apperance_id'   => $faker->randomDigit($min = 1,
             $max = 3),**/
        'children_id' => $faker->numberBetween($min = 1,
            $max = 4),
        'smoking_id'  => $faker->numberBetween($min = 1,
            $max = 4),
        'relation_id'    => $faker->numberBetween($min = 1,
            $max = 6),
        'status_message' => $faker->realText($maxNbChars = 191, $indexSize = 2),

        'main_image' => function () {
            $int = random_int(1, 60);

            return $image = $int.".jpg";
        },

        'apperance_id' => function () {
            $int = random_int(1, 4);
            if ($int = 4) {
                return null;
            } else {
                return $int;
            }
        },



    ];
});
