<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetallesVentaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detalle_ventas')->insert([
            [
                'venta_id' => 1,
                'variante_id' => 1,
                'cantidad' => 2,
                'precio_cobrado' => 45000.00,
            ],
        ]);
    }
}