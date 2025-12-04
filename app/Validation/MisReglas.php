<?php


namespace App\Validation;

class MisReglas
{
    public function tituloMateriaUnico(string $str, string $fields, array $data): bool
    {
        list($table, $column) = explode('.', $fields);

        $db = \Config\Database::connect();

        // Normalizar el título ingresado
        $normalizado = $this->normalizar($str);

        // Obtener todos los títulos de la BD
        $resultados = $db->table($table)->select($column)->get()->getResultArray();

        foreach ($resultados as $fila) {
            $tituloBD = $this->normalizar($fila[$column]);

            if ($normalizado === $tituloBD) {
                return false; // Ya existe uno igual (considerando normalización)
            }
        }

        return true;
    }

    private function normalizar($texto)
    {
        // Quitar acentos
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);

        // Minúsculas
        $texto = strtolower($texto);

        // Quitar signos de puntuación y símbolos comunes
        $texto = preg_replace('/[.,!?:;\"\'\(\)\[\]\{\}\-\–_\…]/u', '', $texto);

        // Quitar cualquier otro símbolo que no sea letra o número
        $texto = preg_replace('/[^a-z0-9\s]/u', '', $texto);

        // Quitar espacios múltiples
        $texto = preg_replace('/\s+/', ' ', $texto);

        return trim($texto);
    }
}


?>