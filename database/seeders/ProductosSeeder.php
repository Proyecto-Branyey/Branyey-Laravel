<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos los IDs para asegurar que la relación exista
        $estiloPolo = DB::table('estilos_camisa')->where('nombre', 'Polo')->value('id') ?? 1;
        $estiloFormal = DB::table('estilos_camisa')->where('nombre', 'Formal')->value('id') ?? 2;

        $nino = DB::table('clasificacion_talla')->where('nombre', 'Niño')->value('id') ?? 1;
        $dama = DB::table('clasificacion_talla')->where('nombre', 'Dama')->value('id') ?? 2;
        $adulto = DB::table('clasificacion_talla')->where('nombre', 'Adulto')->value('id') ?? 3;

        DB::table('productos')->insert([
            [
                'estilo_id' => $estiloPolo,
                'clasificacion_id' => $adulto,
                'nombre_comercial' => 'Camisa Polo Premium Hombre',
                'descripcion' => 'Camisa tipo polo en algodón piqué de alta calidad.',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'estilo_id' => $estiloPolo,
                'clasificacion_id' => $nino,
                'nombre_comercial' => 'Camisa Polo Kids Explorer',
                'descripcion' => 'Resistente y cómoda para los más pequeños.',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'estilo_id' => $estiloFormal,
                'clasificacion_id' => $dama,
                'nombre_comercial' => 'Blusa Oxford Ejecutiva',
                'descripcion' => 'Corte entallado y tela fresca para oficina.',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}