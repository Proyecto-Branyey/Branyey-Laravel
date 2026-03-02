<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetallesOrdenSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar que exista al menos una venta
        $venta = DB::table('ventas')->first();
        
        if (!$venta) {
            $this->command->error('No hay ventas. Ejecuta primero VentasSeeder');
            return;
        }

        DB::table('detalles_orden')->insert([
            [
                'venta_id' => $venta->id,
                'nombre_cliente' => 'Cliente Ejemplo',
                'email_cliente' => 'cliente@email.com',
                'telefono_cliente' => '3001234567',
                'direccion_envio' => 'Dirección de ejemplo #123',
                'ciudad' => 'Ciudad Ejemplo',
                'departamento' => 'Departamento Ejemplo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}