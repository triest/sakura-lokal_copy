<?php

use Illuminate\Database\Seeder;

class AddChildrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('children')->insert([
            'name' => 'Нет',
        ]);

        DB::table('children')->insert([
            'name' => 'Нет, но хотелось бы',
        ]);

        DB::table('children')->insert([
            'name' => 'Нет, и не хочу',
        ]);

        DB::table('children')->insert([
            'name' => 'Есть',
        ]);

        DB::table('children')->insert([
            'name' => 'Есть, живём вмесе',
        ]);

        DB::table('children')->insert([
            'name' => 'Есть, живём рздельно',
        ]);

        DB::table('children')->insert([
            'name' => 'Есть, хочу ещё',
        ]);

        DB::table('children')->insert([
            'name' => 'Есть, больше не хочу',
        ]);
    }
}
