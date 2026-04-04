<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    // Agregué 'descripcion' por si quieres detallar los beneficios de cada rol
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    /**
     * Relación con los usuarios de Branyey
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
    
    /**
     * Verificar si es un rol específico
     * Útil para: $user->rol->es('Mayorista')
     */
    public function es(string $nombreRol): bool
    {
        return strtolower($this->nombre) === strtolower($nombreRol);
    }

    /**
     * Scopes para facilitar consultas en el sistema
     */
    public function scopeNombre($query, $nombre)
    {
        return $query->where('nombre', $nombre);
    }

    public function scopeExcluir($query, array $roles)
    {
        return $query->whereNotIn('nombre', $roles);
    }
}