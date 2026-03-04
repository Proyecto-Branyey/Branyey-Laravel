<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'nombre'
    ];

    protected $dates = ['deleted_at'];

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