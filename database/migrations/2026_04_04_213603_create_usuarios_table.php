<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique(); // 👈 agregado
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('rol_id')->constrained('roles');
            $table->rememberToken();

            // 👇 campos adicionales que ya estabas usando
            $table->string('telefono')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('direccion_defecto')->nullable();
            $table->string('ciudad_defecto')->nullable();
            $table->string('departamento_defecto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};