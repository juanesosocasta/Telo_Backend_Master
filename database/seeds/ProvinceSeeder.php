<?php

use Illuminate\Database\Seeder;

use \App\Province as Department;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('provinces')->truncate();
        Department::create($this->provinceWithCountry("Amazonas"));
        Department::create($this->provinceWithCountry("Antioquia"));
        Department::create($this->provinceWithCountry("Arauca"));
        Department::create($this->provinceWithCountry("Atlántico"));
        Department::create($this->provinceWithCountry("Bolívar"));
        Department::create($this->provinceWithCountry("Boyacá"));
        Department::create($this->provinceWithCountry("Caldas"));
        Department::create($this->provinceWithCountry("Caquetá"));
        Department::create($this->provinceWithCountry("Casanare"));
        Department::create($this->provinceWithCountry("Cauca"));
        Department::create($this->provinceWithCountry("Cesar"));
        Department::create($this->provinceWithCountry("Chocó"));
        Department::create($this->provinceWithCountry("Córdoba"));
        Department::create($this->provinceWithCountry("Cundinamarca"));
        Department::create($this->provinceWithCountry("Guainia"));
        Department::create($this->provinceWithCountry("Guaviare"));
        Department::create($this->provinceWithCountry("Huila"));
        Department::create($this->provinceWithCountry("La Guajira"));
        Department::create($this->provinceWithCountry("Magdalena"));
        Department::create($this->provinceWithCountry("Meta"));
        Department::create($this->provinceWithCountry("Nariño"));
        Department::create($this->provinceWithCountry("Norte de Santander"));
        Department::create($this->provinceWithCountry("Putumayo"));
        Department::create($this->provinceWithCountry("Quindío"));
        Department::create($this->provinceWithCountry("Risaralda"));
        Department::create($this->provinceWithCountry("San Andrés y Providencia"));
        Department::create($this->provinceWithCountry("Santander"));
        Department::create($this->provinceWithCountry("Sucre"));
        Department::create($this->provinceWithCountry("Tolima"));
        Department::create($this->provinceWithCountry("Valle del Cauca"));
        Department::create($this->provinceWithCountry("Vaupés"));
        Department::create($this->provinceWithCountry("Vichada"));
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * @param $name
     * @param int $country
     * @return array
     */
    private function provinceWithCountry($name ,$country=1)
    {
        return ['name' => $name, 'country_id' => $country];
    }
}
