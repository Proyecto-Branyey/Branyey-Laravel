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
            $table->integer('estilo_id')->unsigned();
            $table->string('nombre_comercial', 255);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreign('estilo_id')->references('id')->on('estilos_camisa');
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