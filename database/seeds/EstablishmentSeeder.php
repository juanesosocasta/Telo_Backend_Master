<?php

use Illuminate\Database\Seeder;
use App\Establishment; // Ensure this path is correct, or adjust it to the actual namespace of the Establishment model

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Establishment::create([
            'name' => 'Hotel Example',
            'address' => 'Calle 123 # 45-67',
            'latitude' => 5.0661,
            'longitude' => -75.5176,
            'city_id' => 1, // Manizales
            'customer_id' => 1 // Juan Pérez
        ]);
    }
}
