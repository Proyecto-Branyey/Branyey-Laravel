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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            
            // Usamos foreignId para mayor compatibilidad con las convenciones de Laravel
            $table->foreignId('estilo_id')->constrained('estilos_camisa');
            
            // Añadimos la clasificación (Niño, Dama, Adulto)
            $table->foreignId('clasificacion_id')->constrained('clasificacion_talla');
            
            $table->string('nombre_comercial', 255);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            
            // timestamps opcionales, pero recomendados en Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};