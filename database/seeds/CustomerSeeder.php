<?php

use Illuminate\Database\Seeder;
use App\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('customers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        Customer::create([
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan@admin.com',
            'password' => Hash::make('admin123')
        ]);
    }
}
