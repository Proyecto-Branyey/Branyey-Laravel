<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'tallas';
    
    protected $fillable = [
        'nombre',
        'recargo_minorista',
        'recargo_mayorista'
    ];
    
    protected $casts = [
        'recargo_minorista' => 'float',
        'recargo_mayorista' => 'float',
    ];

    // Se eliminó SoftDeletes y la propiedad $dates para evitar conflictos con la DB
    
    public function variantes()
    {
        return $this->hasMany(Variante::class);
    }
    
    public function tieneRecargos(): bool
    {
        return $this->recargo_minorista > 0 || $this->recargo_mayorista > 0;
    }
    
    public function getRecargo(string $tipo = 'minorista'): float
    {
        if ($tipo === 'mayorista') {
            return $this->recargo_mayorista;
        }
        return $this->recargo_minorista;
    }
    
    // Scope para filtrar tallas con recargos
    public function scopeConRecargos($query)
    {
        return $query->where('recargo_minorista', '>', 0)
                     ->orWhere('recargo_mayorista', '>', 0);
    }
    
    // Scope para ordenar (Ajustado para mayor compatibilidad)
    public function scopeOrdenNatural($query)
    {
        return $query->orderBy('nombre', 'asc');
    }
}