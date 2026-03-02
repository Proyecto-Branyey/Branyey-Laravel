<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::factory()->admin()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'nombre_completo' => 'Administrador Principal',
            'telefono' => '3001234567',
            'direccion_defecto' => 'Calle Principal 123',
            'ciudad_defecto' => 'Bogotá',
            'departamento_defecto' => 'Cundinamarca',
        ]);

        // Usuario mayorista
        User::factory()->mayorista()->create([
            'username' => 'mayorista1',
            'email' => 'mayorista@example.com',
            'nombre_completo' => 'Juan Mayorista',
            'telefono' => '3007654321',
            'direccion_defecto' => 'Carrera 45 #67-89',
            'ciudad_defecto' => 'Medellín',
            'departamento_defecto' => 'Antioquia',
        ]);

        // Usuario minorista
        User::factory()->minorista()->create([
            'username' => 'minorista1',
            'email' => 'minorista@example.com',
            'nombre_completo' => 'Pedro Minorista',
            'telefono' => '3109876543',
            'direccion_defecto' => 'Avenida 68 #45-23',
            'ciudad_defecto' => 'Cali',
            'departamento_defecto' => 'Valle del Cauca',
        ]);

        // Usuarios de prueba aleatorios
        User::factory()->count(15)->create();
    }
}