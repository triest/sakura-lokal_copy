<?php

use Illuminate\Database\Seeder;

class InteresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('interests')->insert([
            'name' => 'Прогулки',
        ]);

        DB::table('interests')->insert([
            'name' => 'Настольные игры',
        ]);

        DB::table('interests')->insert([
            'name' => 'Отщение',
        ]);

        DB::table('interests')->insert([
            'name' => 'Походы',
        ]);

        DB::table('interests')->insert([
            'name' => 'Кино',
        ]);
    }
}
