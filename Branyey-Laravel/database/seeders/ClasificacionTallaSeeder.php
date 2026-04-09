<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionTallaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clasificacion_talla')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'Niño', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Dama', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Adulto', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
