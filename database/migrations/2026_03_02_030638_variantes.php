<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->onDelete('cascade');

            // ✅ CORRECTO (BIGINT compatible)
            $table->foreignId('talla_id')
                  ->constrained('tallas');

            $table->string('sku', 100)->unique();
            $table->integer('stock')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes');
    }
};