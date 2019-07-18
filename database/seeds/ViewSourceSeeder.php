<?php

use Illuminate\Database\Seeder;

class ViewSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('view_source')->insert([
            'name' => 'mainstream',
        ]);
        DB::table('view_source')->insert([
            'name' => 'seach',
        ]);
        DB::table('view_source')->insert([
            'name' => 'who_see',
        ]);
        DB::table('view_source')->insert([
            'name' => 'messages',
        ]);
        DB::table('view_source')->insert([
            'name' => 'top',
        ]);
        DB::table('view_source')->insert([
            'name' => 'events',
        ]);
    }
}
