<?php

use Illuminate\Database\Seeder;
use App\Province as Department;
use App\Util\ExcelUtil;
use App\City;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('cities')->truncate();
        
        $excelUtil = new ExcelUtil();
        
        if ($excelUtil->convertExcelToJson(__DIR__.'/cities.xlsx')) {
            $rows = $excelUtil->getContentInFormatJson();
            
            // Saltar encabezado si existe (primera fila)
            array_shift($rows);

            foreach ($rows as $row) {
                // Usar índices numéricos y validar datos
                $cityName = $this->sanitizeValue($row[0] ?? null);  // Columna A = índice 0
                $provinceName = $this->sanitizeValue($row[1] ?? null); // Columna B = índice 1

                if (empty($cityName) || empty($provinceName)) {
                    continue; // Saltar filas vacías o incompletas
                }

                $department = Department::where('name', $provinceName)->first();
                
                if ($department) {
                    $this->storeCity($cityName, $department->id);
                }
            }
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    private function storeCity(string $cityName, int $departmentId): void
    {
        City::create([
            'province_id' => $departmentId,
            'name' => $cityName
        ]);
    }

    private function sanitizeValue($value): string
    {
        // Convertir arrays a strings y limpiar espacios
        if (is_array($value)) {
            return trim(implode(' ', $value));
        }
        
        return trim((string) $value);
    }
}
