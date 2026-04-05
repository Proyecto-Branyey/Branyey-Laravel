<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            ['nombre' => 'azul bebe'],
            ['nombre' => 'azul oscuro'],
            ['nombre' => 'azul petroleo'],
            ['nombre' => 'azul rey'],
            ['nombre' => 'beige'],
            ['nombre' => 'blanco'],
            ['nombre' => 'gris jaspe'],
            ['nombre' => 'mostaza'],
            ['nombre' => 'negro'],
            ['nombre' => 'rojo'],
            ['nombre' => 'vino tinto'],
            ['nombre' => 'verde botella'],
            ['nombre' => 'verde menta'],
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