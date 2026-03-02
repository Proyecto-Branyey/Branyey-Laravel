<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('variantes')->insert([
            // Producto 1 (Clásico)
            [
                'producto_id' => 1,
                'talla_id' => 1,
                'sku' => 'POL-CLA-S-001',
                'stock' => 15,
            ],
            [
                'producto_id' => 1,
                'talla_id' => 2,
                'sku' => 'POL-CLA-M-002',
                'stock' => 20,
            ],
            [
                'producto_id' => 1,
                'talla_id' => 3,
                'sku' => 'POL-CLA-L-003',
                'stock' => 12,
            ],
            
            // Producto 2 (Clásico)
            [
                'producto_id' => 2,
                'talla_id' => 1,
                'sku' => 'POL-CLA-S-004',
                'stock' => 10,
            ],
            [
                'producto_id' => 2,
                'talla_id' => 2,
                'sku' => 'POL-CLA-M-005',
                'stock' => 18,
            ],
            
            // Producto 3 (Slim Fit)
            [
                'producto_id' => 3,
                'talla_id' => 2,
                'sku' => 'POL-SLM-M-006',
                'stock' => 8,
            ],
            [
                'producto_id' => 3,
                'talla_id' => 3,
                'sku' => 'POL-SLM-L-007',
                'stock' => 6,
            ],
            [
                'producto_id' => 3,
                'talla_id' => 4,
                'sku' => 'POL-SLM-XL-008',
                'stock' => 4,
            ],
            
            // Producto 4 (Slim Fit)
            [
                'producto_id' => 4,
                'talla_id' => 1,
                'sku' => 'POL-SLM-S-009',
                'stock' => 7,
            ],
            [
                'producto_id' => 4,
                'talla_id' => 2,
                'sku' => 'POL-SLM-M-010',
                'stock' => 9,
            ],
            
            // Producto 5 (Moderno)
            [
                'producto_id' => 5,
                'talla_id' => 2,
                'sku' => 'POL-MOD-M-011',
                'stock' => 5,
            ],
            [
                'producto_id' => 5,
                'talla_id' => 3,
                'sku' => 'POL-MOD-L-012',
                'stock' => 3,
            ],
        ]);
    }
}