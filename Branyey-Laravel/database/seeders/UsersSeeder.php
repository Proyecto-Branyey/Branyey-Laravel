<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre_completo' => 'Juan Carlos Rodríguez',
            'username' => 'admin',
            'email' => 'admin@branyey.com',
            'password' => Hash::make('admin123'),
            'rol_id' => 1,
            'telefono' => '3112223344',
            'direccion_defecto' => 'Calle 85 # 12-34, Oficina 502',
            'ciudad_defecto' => 'Bogotá',
            'departamento_defecto' => 'Bogotá D.C.',
            'activo' => true,
        ]);

        User::create([
            'nombre_completo' => 'María Fernanda López',
            'username' => 'mayorista',
            'email' => 'mayorista@branyey.com',
            'password' => Hash::make('mayorista123'),
            'rol_id' => 2,
            'telefono' => '3004567890',
            'direccion_defecto' => 'Cra 43A # 10-50, Local 203',
            'ciudad_defecto' => 'Medellín',
            'departamento_defecto' => 'Antioquia',
            'activo' => true,
        ]);

        User::create([
            'nombre_completo' => 'Carlos Andrés Pérez',
            'username' => 'minorista',
            'email' => 'minorista@branyey.com',
            'password' => Hash::make('minorista123'),
            'rol_id' => 3,
            'telefono' => '3109876543',
            'direccion_defecto' => 'Calle 70 # 15-20, Apto 301',
            'ciudad_defecto' => 'Cali',
            'departamento_defecto' => 'Valle del Cauca',
            'activo' => true,
        ]);

        User::create([
            'nombre_completo' => 'Laura Valentina Gómez',
            'username' => 'laura_gomez',
            'email' => 'laura@example.com',
            'password' => Hash::make('cliente123'),
            'rol_id' => 3,
            'telefono' => '3012345678',
            'direccion_defecto' => 'Calle 34 # 22-11',
            'ciudad_defecto' => 'Barranquilla',
            'departamento_defecto' => 'Atlántico',
            'activo' => true,
        ]);

        User::create([
            'nombre_completo' => 'Empresa Textil del Caribe',
            'username' => 'textil_caribe',
            'email' => 'ventas@textilcaribe.com',
            'password' => Hash::make('empresa456'),
            'rol_id' => 2,
            'telefono' => '3051234567',
            'direccion_defecto' => 'Zona Franca, Bodega 45',
            'ciudad_defecto' => 'Cartagena',
            'departamento_defecto' => 'Bolívar',
            'activo' => true,
        ]);
    }
}