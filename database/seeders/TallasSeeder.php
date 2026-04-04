<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallasSeeder extends Seeder
{
    public function run(): void
    {
        $tallas = [
            // Infantiles
            ['nombre' => '2', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '4', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '6', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '8', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '10', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '12', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '14', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '16', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            
            // Dama (Mayúsculas para diferenciar visualmente si quieres)
            ['nombre' => 'S', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'M', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'L', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'XL', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],

            // Adulto/Caballero
            ['nombre' => 's', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'm', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'l', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'xl', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'xxl', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
        ];

        DB::table('tallas')->insert($tallas);
    }
}