<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstiloCamisa extends Model
{
    use HasFactory;

    protected $table = 'estilos_camisa';

    protected $fillable = [
        'nombre',
    ];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'estilo_id');
    }

    public function scopeNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }
}