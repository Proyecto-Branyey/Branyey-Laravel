<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstiloCamisa extends Model
{
    protected $table = 'estilos_camisa';
    
    protected $fillable = [
        'nombre',
        'precio_base_minorista',
        'precio_base_mayorista'
    ];

    protected $casts = [
        'precio_base_minorista' => 'float',
        'precio_base_mayorista' => 'float',
    ];
    public function productos()
    {
        return $this->hasMany(Producto::class, 'estilo_id');
    }
    
    public function tienePreciosBase(): bool
    {
        return $this->precio_base_minorista > 0 || $this->precio_base_mayorista > 0;
    }
    
    /**
     * Obtener precio base según tipo de cliente
     */
    public function getPrecioBase(string $tipo = 'minorista'): float
    {
        if ($tipo === 'mayorista') {
            return $this->precio_base_mayorista;
        }
        return $this->precio_base_minorista;
    }
    
    /**
     * Formatear precios para mostrar
     */
    public function getPrecioMinoristaFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_base_minorista, 2);
    }
    
    public function getPrecioMayoristaFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_base_mayorista, 2);
    }

    public function scopeConPrecios($query)
    {
        return $query->where('precio_base_minorista', '>', 0)
                     ->orWhere('precio_base_mayorista', '>', 0);
    }

    public function scopeNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }
}