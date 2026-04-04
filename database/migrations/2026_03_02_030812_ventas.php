<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('ventas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('usuario_id')
          ->nullable()
          ->constrained('usuarios')
          ->nullOnDelete();

    $table->decimal('total', 12, 2);

    // ✅ ESTA ES LA QUE FALTA
    $table->enum('estado', ['pendiente', 'pagado', 'enviado', 'cancelado'])
          ->default('pendiente');

    $table->timestamp('fecha')->useCurrent();

    $table->timestamps();
});
}
};