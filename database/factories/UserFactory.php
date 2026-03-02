<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'rol_id' => fake()->numberBetween(1, 3), // Asigna aleatoriamente entre 1-3 (admin, mayorista, minorista)
            'telefono' => fake()->optional()->phoneNumber(),
            'nombre_completo' => fake()->optional()->name(),
            'direccion_defecto' => fake()->optional()->streetAddress(),
            'ciudad_defecto' => fake()->optional()->city(),
            'departamento_defecto' => fake()->optional()->state(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Estado para crear un usuario administrador
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol_id' => 1, // ID del rol administrador
        ]);
    }

    /**
     * Estado para crear un usuario mayorista
     */
    public function mayorista(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol_id' => 2, // ID del rol mayorista
        ]);
    }

    /**
     * Estado para crear un usuario minorista
     */
    public function minorista(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol_id' => 3, // ID del rol minorista
        ]);
    }
}