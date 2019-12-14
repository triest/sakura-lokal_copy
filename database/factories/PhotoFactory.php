<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(App\Photo::class, function (Faker $faker) {

    return [
        //
        'photo_name' => function () {
            $int = random_int(61, 148);

            return $image = $int.".jpg";
        },

    ];
}
);


