<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre'
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
    
    /**
     * Verificar si es un rol específico
     */
    public function es(string $nombreRol): bool
    {
        return strtolower($this->nombre) === strtolower($nombreRol);
    }

    public function scopeNombre($query, $nombre)
    {
        return $query->where('nombre', $nombre);
    }

    public function scopeExcluir($query, array $roles)
    {
        return $query->whereNotIn('nombre', $roles);
    }
}