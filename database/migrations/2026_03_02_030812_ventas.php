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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('usuario_id')->unsigned()->nullable();
            $table->decimal('total', 12, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'enviado', 'cancelado'])->default('pendiente');
            $table->timestamp('fecha')->useCurrent();
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};