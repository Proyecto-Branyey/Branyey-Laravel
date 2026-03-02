<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar que existan los roles antes de crear usuarios
        $roles = DB::table('roles')->count();
        if ($roles === 0) {
            $this->command->error('¡Error! Primero debes ejecutar RolesSeeder');
            $this->command->line('Ejecuta: php artisan db:seed --class=RolesSeeder');
            return;
        }

        // Usuario administrador (rol_id = 1)
        User::factory()->admin()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'nombre_completo' => 'Administrador Principal',
            'telefono' => '3001234567',
            'direccion_defecto' => 'Calle Principal 123',
            'ciudad_defecto' => 'Bogotá',
            'departamento_defecto' => 'Cundinamarca',
        ]);

        // Usuario mayorista (rol_id = 2)
        User::factory()->mayorista()->create([
            'username' => 'mayorista1',
            'email' => 'mayorista@example.com',
            'nombre_completo' => 'Juan Mayorista',
            'telefono' => '3007654321',
            'direccion_defecto' => 'Carrera 45 #67-89',
            'ciudad_defecto' => 'Medellín',
            'departamento_defecto' => 'Antioquia',
        ]);

        // Usuario minorista (rol_id = 3)
        User::factory()->minorista()->create([
            'username' => 'minorista1',
            'email' => 'minorista@example.com',
            'nombre_completo' => 'Pedro Minorista',
            'telefono' => '3109876543',
            'direccion_defecto' => 'Avenida 68 #45-23',
            'ciudad_defecto' => 'Cali',
            'departamento_defecto' => 'Valle del Cauca',
        ]);

        // Crear 10 usuarios minoristas aleatorios adicionales
        User::factory()->minorista()->count(10)->create();

        // Opcional: crear algunos usuarios mayoristas aleatorios
        User::factory()->mayorista()->count(3)->create();

        $this->command->info('Usuarios creados exitosamente:');
        $this->command->line('- 1 administrador');
        $this->command->line('- 4 mayoristas (1 fijo + 3 aleatorios)');
        $this->command->line('- 11 minoristas (1 fijo + 10 aleatorios)');
    }
}