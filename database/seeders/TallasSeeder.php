<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallasSeeder extends Seeder
{
    public function run(): void
    {
        $tallas = [
            // Infantiles (Clasificación ID: 1)
            ['nombre' => '2', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '4', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '6', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '8', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '10', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '12', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '14', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '16', 'clasificacion_id' => 1, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            
            // Dama (Clasificación ID: 2)
            ['nombre' => 'S', 'clasificacion_id' => 2, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'M', 'clasificacion_id' => 2, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'L', 'clasificacion_id' => 2, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'XL', 'clasificacion_id' => 2, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],

            // Adulto/Caballero (Clasificación ID: 3)
            ['nombre' => 's', 'clasificacion_id' => 3, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'm', 'clasificacion_id' => 3, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'l', 'clasificacion_id' => 3, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'xl', 'clasificacion_id' => 3, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'xxl', 'clasificacion_id' => 3, 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
        ];

        DB::table('tallas')->insert($tallas);
    }
}