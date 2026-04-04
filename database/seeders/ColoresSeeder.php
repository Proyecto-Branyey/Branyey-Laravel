<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            ['nombre' => 'azul bebe', 'codigo_hex' => '#89CFF0'],
            ['nombre' => 'azul oscuro', 'codigo_hex' => '#00008B'],
            ['nombre' => 'azul petroleo', 'codigo_hex' => '#005F6A'],
            ['nombre' => 'azul rey', 'codigo_hex' => '#4169E1'],
            ['nombre' => 'beige', 'codigo_hex' => '#F5F5DC'],
            ['nombre' => 'blanco', 'codigo_hex' => '#FFFFFF'],
            ['nombre' => 'gris jaspe', 'codigo_hex' => '#B2BEB5'],
            ['nombre' => 'mostaza', 'codigo_hex' => '#FFDB58'],
            ['nombre' => 'negro', 'codigo_hex' => '#000000'],
            ['nombre' => 'rojo', 'codigo_hex' => '#FF0000'],
            ['nombre' => 'vino tinto', 'codigo_hex' => '#800000'],
            ['nombre' => 'verde botella', 'codigo_hex' => '#006A4E'],
            ['nombre' => 'verde menta', 'codigo_hex' => '#98FF98'],
        ];

        // Ordenar alfabéticamente antes de insertar
        usort($colores, fn($a, $b) => strcmp($a['nombre'], $b['nombre']));

        foreach ($colores as &$color) {
            $color['created_at'] = now();
            $color['updated_at'] = now();
        }

        DB::table('colores')->insert($colores);
    }
}