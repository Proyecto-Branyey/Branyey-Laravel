<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            ['nombre' => 'azul bebe', 'codigo_hex' => null],
            ['nombre' => 'azul oscuro', 'codigo_hex' => null],
            ['nombre' => 'azul petroleo', 'codigo_hex' => null],
            ['nombre' => 'azul rey', 'codigo_hex' => null],
            ['nombre' => 'beige', 'codigo_hex' => null],
            ['nombre' => 'beneton', 'codigo_hex' => null],
            ['nombre' => 'blanco', 'codigo_hex' => null],
            ['nombre' => 'gris jaspe', 'codigo_hex' => null],
            ['nombre' => 'gris raton', 'codigo_hex' => null],
            ['nombre' => 'mostaza', 'codigo_hex' => null],
            ['nombre' => 'negro', 'codigo_hex' => null],
            ['nombre' => 'palo rosa', 'codigo_hex' => null],
            ['nombre' => 'petroleo', 'codigo_hex' => null],
            ['nombre' => 'rojo', 'codigo_hex' => null],
            ['nombre' => 'salmon', 'codigo_hex' => null],
            ['nombre' => 'verde botella', 'codigo_hex' => null],
            ['nombre' => 'verde cali', 'codigo_hex' => null],
            ['nombre' => 'verde jade', 'codigo_hex' => null],
            ['nombre' => 'verde menta', 'codigo_hex' => null],
            ['nombre' => 'vino tinto', 'codigo_hex' => null],
        ];

        // Ordenar alfabéticamente
        usort($colores, function($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });

        // Agregar timestamps
        foreach ($colores as &$color) {
            $color['created_at'] = now();
            $color['updated_at'] = now();
        }

        DB::table('colores')->insert($colores);
    }
}