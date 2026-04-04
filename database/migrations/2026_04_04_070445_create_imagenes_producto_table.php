<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('imagenes_producto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->cascadeOnDelete();

            $table->foreignId('color_id')
                  ->constrained('colores')
                  ->cascadeOnDelete();

            $table->string('url', 500);

            $table->boolean('es_principal')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['producto_id', 'color_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_producto');
    }
};