<?php

use Illuminate\Database\Seeder;
use \App\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('countries')->truncate();
        Country::create(['name'=>'Colombia']);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
