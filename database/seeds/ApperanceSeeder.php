<?php

use Illuminate\Database\Seeder;

class ApperanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('appearance')->insert([
            'name' => 'Европейская',
        ]);

        DB::table('appearance')->insert([
            'name' => 'Азиатская',
        ]);

        DB::table('appearance')->insert([
            'name' => 'Кавкзская',
        ]);

    }
}
