<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            ['nombre' => 'azul bebe',      'codigo_hex' => '#B2D7FF', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'azul oscuro',    'codigo_hex' => '#003366', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'azul petroleo',  'codigo_hex' => '#20576B', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'azul rey',       'codigo_hex' => '#0053A0', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'beige',          'codigo_hex' => '#F5F5DC', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'blanco',         'codigo_hex' => '#FFFFFF', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'gris jaspe',     'codigo_hex' => '#B0B0B0', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'mostaza',        'codigo_hex' => '#FFDB58', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'negro',          'codigo_hex' => '#000000', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'rojo',           'codigo_hex' => '#FF0000', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'vino tinto',     'codigo_hex' => '#800020', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'verde botella',  'codigo_hex' => '#006A4E', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'verde menta',    'codigo_hex' => '#98FF98', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('colores')->insertOrIgnore($colores);
    }
}