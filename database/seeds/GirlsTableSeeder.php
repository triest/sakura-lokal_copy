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
        factory(App\Girl::class, 15)->create()->each(function ($girl) {
            $count = rand(0, 10);
            for ($i = 0; $i < $count; $i++) {
                $girl->photos()->save(factory(App\Photo::class)->make());
            }
            $count = rand(0, 10);
            for ($i = 0; $i < $count; $i++) {
                $girl->privatephotos()
                    ->save(factory(App\Privatephoto::class)->make());
            }
            $count = rand(0, 10);
            for ($i = 0; $i < $count; $i++) {
                $girl->target()->save(factory(App\Target::class)->make());
            }
            $count = rand(0, 10);
            for ($i = 0; $i < $count; $i++) {
                $girl->interest()->save(factory(App\Interest::class)->make());
            }
            $count = rand(0, 10);
            for ($i = 0; $i < $count; $i++) {
                $user = factory(App\User::class)->make();
                $girl->user()->save($user)->make();
            }
        });
    }
}
