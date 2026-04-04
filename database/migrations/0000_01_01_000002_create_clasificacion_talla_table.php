<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clasificacion_talla', function (Blueprint $table) {
            $table->id(); // BIGINT

            $table->enum('nombre', ['Niño', 'Dama', 'Adulto'])->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clasificacion_talla');
    }
};