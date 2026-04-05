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
        Schema::create('variante_color', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variante_id')->constrained('variantes')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('colores');
            $table->integer('orden')->default(1);
            $table->timestamps();
            $table->unique(['variante_id', 'color_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variante_color');
    }
};
