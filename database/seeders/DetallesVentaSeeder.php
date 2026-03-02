<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetallesVentaSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar que exista al menos una venta
        $venta = DB::table('ventas')->first();
        
        if (!$venta) {
            $this->command->error('No hay ventas. Ejecuta primero VentasSeeder');
            return;
        }

        // Verificar que exista al menos una variante
        $variante = DB::table('variantes')->first();
        
        if (!$variante) {
            $this->command->error('No hay variantes. Ejecuta primero VariantesSeeder');
            return;
        }

        DB::table('detalle_ventas')->insert([
            [
                'venta_id' => $venta->id,
                'variante_id' => $variante->id,
                'cantidad' => 2,
                'precio_cobrado' => 45000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}