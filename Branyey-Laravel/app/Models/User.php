<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Relación: historial de ventas del usuario
     */
    public function ventas()
    {
        return $this->hasMany(\App\Models\Venta::class, 'usuario_id');
    }

    protected $table = 'usuarios';

    /**
     * Campos asignables
     */
    protected $fillable = [
        'username',
        'email',
        'telefono',
        'nombre_completo',
        'direccion_defecto',
        'ciudad_defecto',
        'departamento_defecto',
        'password',
        'rol_id',
        'activo',
    ];
    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts automáticos
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con Rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Helpers para roles (MUY útil 🔥)
     */
    public function esAdmin(): bool
    {
        return $this->rol_id === 1;
    }

    public function esMayorista(): bool
    {
        return $this->rol_id === 2;
    }

    public function esMinorista(): bool
    {
        return $this->rol_id === 3;
    }
}   