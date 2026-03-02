<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionTallaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up(): void
    {
        $data = [
            ['nombre' => 'Niño'],
            ['nombre' => 'Dama'],
            ['nombre' => 'Adulto'],
        ];

        foreach ($data as $item) {
            // updateOrInsert evita duplicados si corres el seeder varias veces
            DB::table('clasificacion_talla')->updateOrInsert(
                ['nombre' => $item['nombre']],
                $item
            );
        }
    }
}