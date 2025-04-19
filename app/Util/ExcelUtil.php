<?php

namespace App\Util;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Exception;

/**
 * Clase para manejar operaciones con archivos Excel
 */
class ExcelUtil
{
    protected $contentInFormatJson = [];
    protected $errors = [];

    /**
     * Convierte un archivo Excel a formato JSON
     */
    public function convertExcelToJson(string $filePath): bool
    {
        try {
            if (!$this->validateExcelFileExtension($filePath)) {
                $this->errors = ['file' => 'Extensión de archivo no válida'];
                return false;
            }

            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            
            // Convertir a array con índices numéricos
            $this->contentInFormatJson = $sheet->toArray(
                null,       // Valor nulo
                true,       // Valores calculados
                false,      // Formateo
                false       // No usar referencias de celda (A,B,C)
            );

            return true;

        } catch (Exception $e) {
            $this->errors = ['excel' => 'Error al leer el archivo: ' . $e->getMessage()];
            return false;
        }
    }

    /**
     * Obtiene los datos en formato array
     */
    public function getContentInFormatJson(): array
    {
        return $this->contentInFormatJson;
    }

    /**
     * Valida la extensión del archivo
     */
    public function validateExcelFileExtension(string $filePath): bool
    {
        $allowedExtensions = ['xls', 'xlsx'];
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        return in_array($extension, $allowedExtensions);
    }

    /**
     * Obtiene errores
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Procesa valores de celda (evita arrays)
     */
    public static function getCellValue($cellData): string
    {
        if (is_array($cellData)) {
            return implode(' ', $cellData);
        }
        
        return (string) $cellData;
    }
}
