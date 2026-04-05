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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'raya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'unicolor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}