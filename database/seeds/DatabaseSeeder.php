<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        /*     $this->call(ViewSourceSeeder::class);
             $this->call(AddChildrenSeeder::class);
             $this->call(AddSmokingSeeder::class);
             $this->call(AddRelationsSeeder::class);
             $this->call(ApperanceSeeder::class);
             $this->call(TableTableSeeder::class);
             $this->call(CreatePhoneSettingSeed::class);
          */
        $this->call(GirlsTableSeeder::class);
    }
}
