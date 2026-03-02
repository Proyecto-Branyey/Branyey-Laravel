<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener un usuario real que exista
        $usuario = DB::table('users')->first();
        
        if (!$usuario) {
            $this->command->error('No hay usuarios. Ejecuta primero UsersSeeder');
            return;
        }

        DB::table('ventas')->insert([
            [
                'usuario_id' => $usuario->id, // Usar el ID real del primer usuario
                'total' => 185000.00,
                'estado' => 'pendiente',
                'fecha' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}