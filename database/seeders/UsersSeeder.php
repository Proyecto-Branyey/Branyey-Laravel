<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de que el modelo User exista
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opción recomendada: Usar el modelo User
        // Asegúrate de que en app/Models/User.php tengas: protected $table = 'usuarios';
        
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Cambia esta contraseña después
            'remember_token' => \Illuminate\Support\Str::random(10),
            'rol_id' => 3, // Asumiendo que 3 es el ID de 'Admin' en tu RolesSeeder
            'telefono' => '3001234567',
            'nombre_completo' => 'Administrador Principal',
            'direccion_defecto' => 'Calle Principal 123',
            'ciudad_defecto' => 'Bogotá',
            'departamento_defecto' => 'Cundinamarca',
        ]);

        // Si prefieres usar DB::table, asegúrate de que el nombre sea 'usuarios'
        /*
        DB::table('usuarios')->insert([
            'username' => 'usuario_prueba',
            'email' => 'prueba@example.com',
            'password' => Hash::make('password'),
            'rol_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        */
    }
}