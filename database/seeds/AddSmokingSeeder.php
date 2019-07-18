<?php

use Illuminate\Database\Seeder;

class AddSmokingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        DB::table('smoking')->insert([
            'name' => 'Не курю',
        ]);

        DB::table('smoking')->insert([
            'name' => 'Не курю, к курящим отношусь нейтрально',
        ]);

        DB::table('smoking')->insert([
            'name' => 'Не курю, к курящим отношусь отрицательно',
        ]);

        DB::table('smoking')->insert([
            'name' => 'Курю редко',
        ]);


        DB::table('smoking')->insert([
            'name' => 'Курю часто',
        ]);
    }
}
