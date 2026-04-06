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
            $table->foreignId('variante_id')->constrained('variantes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('colores')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('orden')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['variante_id', 'color_id'], 'unique_variante_color');
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
