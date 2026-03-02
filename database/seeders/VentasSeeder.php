<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ventas')->insert([
            [
                'usuario_id' => 1,
                'total' => 185000.00,
                'estado' => 'pendiente',
                'fecha' => now(),
            ],
        ]);
    }
}