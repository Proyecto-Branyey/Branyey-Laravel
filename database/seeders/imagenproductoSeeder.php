<?php
// database/seeders/ImagenesProductoSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenesProductoSeeder extends Seeder
{
    public function run()
    {
        // Asumiendo que ya tienes productos con IDs 1,2,3
        // y que esos productos tienen variantes con estos colores
        
        $imagenes = [
            // Producto 1 - Camisa Clásica
            [
                'id_producto' => 1,
                'color' => 'Rojo',
                'url' => '/storage/productos/clasica-roja.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_producto' => 1,
                'color' => 'Azul',
                'url' => '/storage/productos/clasica-azul.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_producto' => 1,
                'color' => 'Negro',
                'url' => '/storage/productos/clasica-negra.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Producto 2 - Camisa Slim Fit
            [
                'id_producto' => 2,
                'color' => 'Blanco',
                'url' => '/storage/productos/slim-blanca.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_producto' => 2,
                'color' => 'Negro',
                'url' => '/storage/productos/slim-negra.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_producto' => 2,
                'color' => 'Gris',
                'url' => '/storage/productos/slim-gris.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Producto 3 - Camisa Oxford
            [
                'id_producto' => 3,
                'color' => 'Azul',
                'url' => '/storage/productos/oxford-azul.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_producto' => 3,
                'color' => 'Blanco',
                'url' => '/storage/productos/oxford-blanco.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('imagenes_producto')->insert($imagenes);
    }
}