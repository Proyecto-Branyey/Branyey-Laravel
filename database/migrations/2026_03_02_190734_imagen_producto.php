<?php
// database/migrations/2026_03_02_190734_imagen_producto.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  // ← Usando clase anónima (no hay conflicto de nombres)
{
    public function up(): void
    {
        Schema::create('imagenes_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->string('color', 50);
            $table->string('url', 500);
            $table->timestamps();
            
            $table->unique(['id_producto', 'color']);
            
            $table->foreign('id_producto')
                  ->references('id')
                  ->on('productos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_producto');
    }
};