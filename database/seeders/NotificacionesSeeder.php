<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notificacion;

class NotificacionesSeeder extends Seeder
{
    public function run(): void
    {
        Notificacion::create([
            'tipo' => 'venta',
            'mensaje' => 'Nueva venta realizada por el usuario de prueba.',
            'usuario_id' => 1,
            'leida' => 0,
        ]);
        Notificacion::create([
            'tipo' => 'edicion',
            'mensaje' => 'El producto "Camisa Azul" fue editado.',
            'usuario_id' => 1,
            'leida' => 0,
        ]);
        Notificacion::create([
            'tipo' => 'eliminacion',
            'mensaje' => 'El cliente "Juan Pérez" fue eliminado.',
            'usuario_id' => 1,
            'leida' => 0,
        ]);
    }
}
