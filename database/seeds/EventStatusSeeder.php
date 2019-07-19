<?php

use Illuminate\Database\Seeder;

class EventStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('event_statys')->insert([
            'name' => 'Черновик',
        ]);
        DB::table('event_statys')->insert([
            'name' => 'Ожидает участников',
        ]);
        DB::table('event_statys')->insert([
            'name' => 'Все участники собраны, ожидаеться событие',
        ]);
        DB::table('event_statys')->insert([
            'name' => 'Состоялось',
        ]);

        DB::table('event_statys')->insert([
            'name' => 'Отменено',
        ]);
    }
}
