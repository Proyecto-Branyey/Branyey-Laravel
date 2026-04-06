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
            $table->string('username', 255)->unique()->notNullable();
            $table->string('password', 255)->notNullable();
            $table->foreignId('rol_id')->constrained('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->string('email', 255)->unique()->notNullable();
            $table->string('telefono', 50)->nullable();
            $table->string('nombre_completo', 255)->nullable();
            $table->text('direccion_defecto')->nullable();
            $table->string('ciudad_defecto', 100)->nullable();
            $table->string('departamento_defecto', 100)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index('activo', 'idx_usuarios_activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};