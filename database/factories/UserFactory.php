<?php

namespace Database\Factories;

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
            'rol_id' => fake()->numberBetween(1, 3),

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
            'rol_id' => 1,
        ]);
    }

    public function mayorista(): static
    {
        return $this->state(fn () => [
            'rol_id' => 2,
        ]);
    }

    public function minorista(): static
    {
        return $this->state(fn () => [
            'rol_id' => 3,
        ]);
    }
}