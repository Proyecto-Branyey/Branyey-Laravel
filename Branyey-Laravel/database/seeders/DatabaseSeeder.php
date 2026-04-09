<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Mantenemos solo la configuración maestra de Branyey.
     */
    public function run(): void
    {
        // 1. Configuración de Seguridad y Usuarios
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);

        // 2. Configuración Maestra de Ropa (Tablas Paramétricas)
        $this->call(ClasificacionTallaSeeder::class);
        // Seeder de venta de prueba
    }
}