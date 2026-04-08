<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'mayorista', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'minorista', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}