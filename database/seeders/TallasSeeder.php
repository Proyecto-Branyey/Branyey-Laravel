<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallasSeeder extends Seeder
{
    public function run(): void
    {
        $tallas = [
            // Infantil (Clasificación ID: 1)
            ['nombre' => '2', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '4', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '6', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '8', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '10', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '12', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '14', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '16', 'clasificacion_id' => 1, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            // Dama (Clasificación ID: 2)
            ['nombre' => 'S', 'clasificacion_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'M', 'clasificacion_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'L', 'clasificacion_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'XL', 'clasificacion_id' => 2, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            // Adulto/Caballero (Clasificación ID: 3)
            ['nombre' => 's', 'clasificacion_id' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'm', 'clasificacion_id' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'l', 'clasificacion_id' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'xl', 'clasificacion_id' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'xxl', 'clasificacion_id' => 3, 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('tallas')->insertOrIgnore($tallas);
    }
}