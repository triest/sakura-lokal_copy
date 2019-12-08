<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$autoIncrement = autoIncrement();

$factory->define(App\Photo::class,
    function (Faker $faker) use ($autoIncrement) {
        $autoIncrement->next();
    return [
        //
        'photo_name' => function () {
            $int = random_int(61, 148);

            return $image = $int.".jpg";
        }

    ];
});


function autoIncrement()
{
    for ($i = 1; $i < 148; $i++) {
        yield $i;
    }
}
