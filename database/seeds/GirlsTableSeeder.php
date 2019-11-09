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
        factory(App\Girls::class, 50)->create()->each(function ($girl) {
            $girl->photos()->save(factory(App\Photo::class)->make());
        });
    }
}
