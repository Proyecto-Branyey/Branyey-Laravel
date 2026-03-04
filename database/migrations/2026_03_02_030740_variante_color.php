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
            $table->integer('variante_id')->unsigned();
            $table->integer('color_id')->unsigned();
            $table->integer('orden')->default(1);
            $table->softDeletes();
            
            $table->foreign('variante_id')->references('id')->on('variantes')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colores');
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