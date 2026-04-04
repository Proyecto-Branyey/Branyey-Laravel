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

        DB::table('clasificacion_talla')->insert($clasificaciones);
    }
}