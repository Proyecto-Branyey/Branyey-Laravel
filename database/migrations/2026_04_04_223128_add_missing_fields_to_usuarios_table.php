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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('telefono')->nullable()->after('email');
            $table->text('direccion_defecto')->nullable()->after('telefono');
            $table->string('ciudad_defecto')->nullable()->after('direccion_defecto');
            $table->string('departamento_defecto')->nullable()->after('ciudad_defecto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['username', 'telefono', 'direccion_defecto', 'ciudad_defecto', 'departamento_defecto']);
        });
    }
};
