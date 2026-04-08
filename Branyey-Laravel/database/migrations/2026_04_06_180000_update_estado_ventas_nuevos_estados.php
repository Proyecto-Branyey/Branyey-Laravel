<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mapea estados legacy al nuevo flujo operativo.
        DB::table('ventas')->where('estado', 'pendiente')->update(['estado' => 'pagado']);

        DB::statement("ALTER TABLE ventas MODIFY COLUMN estado ENUM('pagado', 'en_proceso', 'enviado', 'entregado', 'cancelado') NOT NULL DEFAULT 'pagado'");
    }

    public function down(): void
    {
        // Mapea estados nuevos al esquema anterior para rollback.
        DB::table('ventas')->where('estado', 'en_proceso')->update(['estado' => 'pagado']);
        DB::table('ventas')->where('estado', 'entregado')->update(['estado' => 'enviado']);

        DB::statement("ALTER TABLE ventas MODIFY COLUMN estado ENUM('pendiente', 'pagado', 'enviado', 'cancelado') NOT NULL DEFAULT 'pendiente'");
    }
};
