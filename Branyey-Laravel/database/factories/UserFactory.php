<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(), // 👈 ahora sí existe en DB
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'rol_id' => $this->getOrCreateRolId('minorista'),

            'telefono' => fake()->optional()->phoneNumber(),
            'nombre_completo' => fake()->optional()->name(),
            'direccion_defecto' => fake()->optional()->streetAddress(),
            'ciudad_defecto' => fake()->optional()->city(),
            'departamento_defecto' => fake()->optional()->state(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'rol_id' => $this->getOrCreateRolId('administrador'),
        ]);
    }

    public function mayorista(): static
    {
        return $this->state(fn () => [
            'rol_id' => $this->getOrCreateRolId('mayorista'),
        ]);
    }

    public function minorista(): static
    {
        return $this->state(fn () => [
            'rol_id' => $this->getOrCreateRolId('minorista'),
        ]);
    }

    private function getOrCreateRolId(string $nombre): int
    {
        return Rol::query()->firstOrCreate(['nombre' => $nombre])->id;
    }
}