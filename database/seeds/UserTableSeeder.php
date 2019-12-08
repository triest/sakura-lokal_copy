<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\User::class, 50)->create()->each(function ($user) {
            //  $user->message()->save(factory(App\Message::class)->make());

            $girl = factory(App\Girl::class)->make();
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->target()->save(factory(App\Target::class)->make());
            $girl->interest()->save(factory(App\Interest::class)->make());
            $user->girl()->save($girl);


        });

    }
}
