<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clasificacion_talla', function (Blueprint $table) {
            $table->id(); // Crea el INT AUTO_INCREMENT PRIMARY KEY
            
            // Crea el campo ENUM con los valores exactos y restricción UNIQUE
            $table->enum('nombre', ['Niño', 'Dama', 'Adulto'])->unique();
        });

        // Insertamos los datos iniciales de una vez para que la tabla no quede vacía
        DB::table('clasificacion_talla')->insert([
            ['nombre' => 'Niño'],
            ['nombre' => 'Dama'],
            ['nombre' => 'Adulto'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clasificacion_talla');
    }
};