<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetallesOrdenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detalles_orden')->insert([
            [
                'venta_id' => 1,
                'nombre_cliente' => 'Cliente Ejemplo',
                'email_cliente' => 'cliente@email.com',
                'telefono_cliente' => '3001234567',
                'direccion_envio' => 'Dirección de ejemplo #123',
                'ciudad' => 'Ciudad Ejemplo',
                'departamento' => 'Departamento Ejemplo',
            ],
        ]);
    }
}