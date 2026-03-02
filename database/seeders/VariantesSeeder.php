<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantesSeeder extends Seeder
{
    public function run(): void
    {
        // Primero, verificar que existan los productos y tallas
        $productos = DB::table('productos')->get();
        $tallas = DB::table('tallas')->get()->keyBy('nombre');
        
        if ($productos->isEmpty()) {
            $this->command->error('No hay productos. Ejecuta primero ProductosSeeder');
            return;
        }

        if ($tallas->isEmpty()) {
            $this->command->error('No hay tallas. Ejecuta primero TallasSeeder');
            return;
        }

        $variantes = [
            // Producto 1 (Polo Premium Hombre - Adulto) - Usar tallas de letra
            [
                'producto_id' => 1,
                'talla_id' => $tallas['s']->id,  // ID 9
                'sku' => 'POL-CLA-S-001',
                'stock' => 15,
            ],
            [
                'producto_id' => 1,
                'talla_id' => $tallas['m']->id,  // ID 10
                'sku' => 'POL-CLA-M-002',
                'stock' => 20,
            ],
            [
                'producto_id' => 1,
                'talla_id' => $tallas['l']->id,  // ID 11
                'sku' => 'POL-CLA-L-003',
                'stock' => 12,
            ],
            [
                'producto_id' => 1,
                'talla_id' => $tallas['xl']->id, // ID 12
                'sku' => 'POL-CLA-XL-004',
                'stock' => 8,
            ],
            
            // Producto 2 (Polo Kids Explorer - Niño) - Usar tallas numéricas infantiles
            [
                'producto_id' => 2,
                'talla_id' => $tallas['6']->id,  // ID 3
                'sku' => 'POL-KID-6-005',
                'stock' => 10,
            ],
            [
                'producto_id' => 2,
                'talla_id' => $tallas['8']->id,  // ID 4
                'sku' => 'POL-KID-8-006',
                'stock' => 12,
            ],
            [
                'producto_id' => 2,
                'talla_id' => $tallas['10']->id, // ID 5
                'sku' => 'POL-KID-10-007',
                'stock' => 8,
            ],
            [
                'producto_id' => 2,
                'talla_id' => $tallas['12']->id, // ID 6
                'sku' => 'POL-KID-12-008',
                'stock' => 6,
            ],
            
            // Producto 3 (Blusa Oxford Ejecutiva - Dama) - Usar tallas de dama (podrían ser XS, S, M, L)
            // Asumiendo que S=9, M=10, L=11
            [
                'producto_id' => 3,
                'talla_id' => $tallas['s']->id,  // ID 9
                'sku' => 'BLU-OXF-S-009',
                'stock' => 7,
            ],
            [
                'producto_id' => 3,
                'talla_id' => $tallas['m']->id,  // ID 10
                'sku' => 'BLU-OXF-M-010',
                'stock' => 9,
            ],
            [
                'producto_id' => 3,
                'talla_id' => $tallas['l']->id,  // ID 11
                'sku' => 'BLU-OXF-L-011',
                'stock' => 5,
            ],
        ];

        // Agregar timestamps
        foreach ($variantes as &$variante) {
            $variante['created_at'] = now();
            $variante['updated_at'] = now();
        }

        DB::table('variantes')->insert($variantes);
    }
}