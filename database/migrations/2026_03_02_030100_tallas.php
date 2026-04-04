<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tallas', function (Blueprint $table) {
            $table->id(); 

            $table->string('nombre', 10);
            
            // --- ESTA ES LA LÍNEA QUE DEBES AGREGAR ---
            // Asegúrate de que el nombre de la tabla coincida: 'clasificacion_talla'
            $table->foreignId('clasificacion_id')->constrained('clasificacion_talla');
            // ------------------------------------------

            $table->decimal('recargo_minorista', 12, 2)->default(0);
            $table->decimal('recargo_mayorista', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tallas');
    }
};