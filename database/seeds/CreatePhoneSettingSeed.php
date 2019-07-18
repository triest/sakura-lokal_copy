<?php

use Illuminate\Database\Seeder;

class CreatePhoneSettingSeed extends Seeder
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
        DB::table('phone_settings')->insert([
            'id'   => '0',
            'name' => 'Виден всем',
        ]);
        DB::table('phone_settings')->insert([
            'id'   => '1',
            'name' => 'Виден только кому я разрешу',
        ]);
    }
}
