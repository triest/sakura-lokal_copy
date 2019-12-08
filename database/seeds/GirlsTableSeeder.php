<?php

use Illuminate\Database\Seeder;

class GirlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Girl::class, 3)->create()->each(function ($girl) {
            $girl->photos()->save(factory(App\Photo::class)->make());
            $girl->privatephotos()
                ->save(factory(App\Privatephoto::class)->make());
            $girl->target()->save(factory(App\Target::class)->make());
            $girl->interest()->save(factory(App\Interest::class)->make());
            $user = factory(App\User::class)->make();
            $girl->user()->save($user)->make();
            //   $girl->like()->save(factory(App\Like::class)->make());

        });
    }
}
