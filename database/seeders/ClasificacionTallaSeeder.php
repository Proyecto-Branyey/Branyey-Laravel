<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionTallaSeeder extends Seeder
{
    public function run(): void
    {
        $clasificaciones = [
            ['nombre' => 'Niño'],
            ['nombre' => 'Dama'],
            ['nombre' => 'Adulto'],
        ];

        // En ClasificacionTallaSeeder.php o DatabaseSeeder.php
DB::table('clasificacion_talla')->insert([
    ['id' => 1, 'nombre' => 'Niño'],
    ['id' => 2, 'nombre' => 'Dama'],
    ['id' => 3, 'nombre' => 'Adulto'],
]);
    }
}