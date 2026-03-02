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
        Schema::create('tallas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 10); // VARCHAR(10) NOT NULL
            $table->decimal('recargo_minorista', 12, 2)->default(0); // DECIMAL(12,2) DEFAULT 0
            $table->decimal('recargo_mayorista', 12, 2)->default(0); // DECIMAL(12,2) DEFAULT 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tallas');
    }
};