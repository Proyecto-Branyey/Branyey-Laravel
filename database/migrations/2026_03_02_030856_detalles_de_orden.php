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
            $table->integer('venta_id')->unsigned();
            $table->string('nombre_cliente', 255);
            $table->string('email_cliente', 255);
            $table->string('telefono_cliente', 50);
            $table->text('direccion_envio');
            $table->string('ciudad', 100);
            $table->string('departamento', 100);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
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

