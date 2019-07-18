<?php

use Illuminate\Database\Seeder;

class AddRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('relations')->insert([
            'name' => 'Нет',
        ]);

        DB::table('relations')->insert([
            'name' => 'Есть пара',
        ]);

        DB::table('relations')->insert([
            'name' => 'Всё сложно',
        ]);
    }
}
