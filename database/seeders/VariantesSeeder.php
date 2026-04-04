<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantesSeeder extends Seeder
{
    public function run(): void
    {
        $productos = DB::table('productos')->get();

        // Normalizar nombres (clave segura)
        $tallas = DB::table('tallas')
            ->get()
            ->keyBy(fn($t) => strtolower($t->nombre));

        $variantes = [
            [
                'producto_id' => 1,
                'talla_id' => $tallas['s']->id,
                'sku' => 'POL-CLA-S-001',
                'stock' => 15,
            ],
            [
                'producto_id' => 1,
                'talla_id' => $tallas['m']->id,
                'sku' => 'POL-CLA-M-002',
                'stock' => 20,
            ],
            [
                'producto_id' => 1,
                'talla_id' => $tallas['l']->id,
                'sku' => 'POL-CLA-L-003',
                'stock' => 12,
            ],
            [
                'producto_id' => 1,
                'talla_id' => $tallas['xl']->id,
                'sku' => 'POL-CLA-XL-004',
                'stock' => 8,
            ],

            [
                'producto_id' => 2,
                'talla_id' => $tallas['6']->id,
                'sku' => 'POL-KID-6-005',
                'stock' => 10,
            ],
            [
                'producto_id' => 2,
                'talla_id' => $tallas['8']->id,
                'sku' => 'POL-KID-8-006',
                'stock' => 12,
            ],
        ];

        foreach ($variantes as &$v) {
            $v['created_at'] = now();
            $v['updated_at'] = now();
        }

        DB::table('variantes')->insert($variantes);
    }
}