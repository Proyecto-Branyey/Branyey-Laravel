<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EjemploVentaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear producto de ejemplo
        $productoId = DB::table('productos')->insertGetId([
            'estilo_id' => 1, // Debe existir en estilos_camisa
            'clasificacion_id' => 1, // Debe existir en clasificacion_talla
            'nombre_comercial' => 'Camisa Ejemplo',
            'descripcion' => 'Camisa de prueba para venta de ejemplo',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Crear dos variantes para ese producto
        $varianteId1 = DB::table('variantes')->insertGetId([
            'producto_id' => $productoId,
            'talla_id' => 1, // Debe existir en tallas
            'sku' => 'SKU-EX-001',
            'stock' => 10,
            'precio_minorista' => 50000,
            'precio_mayorista' => 40000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $varianteId2 = DB::table('variantes')->insertGetId([
            'producto_id' => $productoId,
            'talla_id' => 2, // Debe existir en tallas
            'sku' => 'SKU-EX-002',
            'stock' => 5,
            'precio_minorista' => 50000,
            'precio_mayorista' => 40000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Insertar una venta
        $ventaId = DB::table('ventas')->insertGetId([
            'usuario_id' => 1, // Admin
            'total' => 150000,
            'estado' => 'pagado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Insertar detalles de orden (envío)
        DB::table('detalles_orden')->insert([
            'venta_id' => $ventaId,
            'nombre_cliente' => 'Juan Pérez',
            'email_cliente' => 'juanperez@example.com',
            'telefono_cliente' => '3001234567',
            'direccion_envio' => 'Calle 123 #45-67',
            'ciudad' => 'Bogotá',
            'departamento' => 'Cundinamarca',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Insertar detalles de productos vendidos
        DB::table('detalle_ventas')->insert([
            [
                'venta_id' => $ventaId,
                'variante_id' => $varianteId1,
                'cantidad' => 2,
                'precio_cobrado' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'venta_id' => $ventaId,
                'variante_id' => $varianteId2,
                'cantidad' => 1,
                'precio_cobrado' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
