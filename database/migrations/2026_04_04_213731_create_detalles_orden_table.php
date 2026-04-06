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
        Schema::create('detalles_orden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nombre_cliente', 255)->notNullable();
            $table->string('email_cliente', 255)->notNullable();
            $table->string('telefono_cliente', 50)->notNullable();
            $table->text('direccion_envio')->notNullable();
            $table->string('ciudad', 100)->notNullable();
            $table->string('departamento', 100)->notNullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_orden');
    }
};
