<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ // <--- ESTA ES LA LLAVE QUE FALTA O ESTÁ MAL PUESTA
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variante_color', function (Blueprint $table) {
            $table->id();

            // Relación con variantes (Asegúrate de que sea BigInteger con foreignId)
            $table->foreignId('variante_id')->constrained('variantes')->onDelete('cascade');

            // Relación con colores (Asegúrate de que la tabla 'colores' exista)
            $table->foreignId('color_id')->constrained('colores')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variante_color');
    }
}; // <--- Y ESTA CIERRA LA CLASE