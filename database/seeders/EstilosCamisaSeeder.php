<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstilosCamisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estilos_camisa')->insert([
            [
                'nombre' => 'estampado',
                'precio_base_minorista' => 0,
                'precio_base_mayorista' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'raya',
                'precio_base_minorista' => 0,
                'precio_base_mayorista' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'unicolor',
                'precio_base_minorista' => 0,
                'precio_base_mayorista' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}