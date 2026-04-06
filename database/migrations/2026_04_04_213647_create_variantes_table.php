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
        Schema::create('variantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('talla_id')->constrained('tallas')->onUpdate('cascade')->onDelete('restrict');
            $table->string('sku', 100)->unique()->notNullable();
            $table->integer('stock')->default(0);
            $table->decimal('precio_minorista', 10, 2)->default(0);
            $table->decimal('precio_mayorista', 10, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index('activo', 'idx_variantes_activo');
            $table->index('sku', 'idx_variantes_sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variantes');
    }
};
