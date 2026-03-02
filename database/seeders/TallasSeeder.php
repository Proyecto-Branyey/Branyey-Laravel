<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tallas = [
            // Tallas numéricas (infantil/juvenil)
            ['nombre' => '2', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '4', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '6', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '8', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '10', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '12', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '14', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => '16', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            
            // Tallas letras (adulto)
            ['nombre' => 's', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'm', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'l', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'xl', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
            ['nombre' => 'xxl', 'recargo_minorista' => 0, 'recargo_mayorista' => 0],
        ];

        // Agregar timestamps a cada registro
        foreach ($tallas as &$talla) {
            $talla['created_at'] = now();
            $talla['updated_at'] = now();
        }

        DB::table('tallas')->insert($tallas);
    }
}