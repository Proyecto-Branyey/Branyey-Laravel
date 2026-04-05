<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstiloCamisa extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'estilos_camisa';

    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
    ];

    // Desactivamos timestamps si no los tienes en la migración de estilos
    public $timestamps = false;

    // ==========================================
    // RELACIONES
    // ==========================================

    /**
     * Un estilo tiene muchos productos asociados.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'estilo_id');
    }

    // ==========================================
    // LÓGICA DE NEGOCIO
    // ==========================================
    
    /**
     * Verifica si el estilo tiene algún precio configurado.
     */
    public function tienePreciosBase(): bool
    {
        return $this->precio_base_minorista > 0 || $this->precio_base_mayorista > 0;
    }
    
    /**
     * Obtener precio base según tipo de cliente.
     */
    public function getPrecioBase(string $tipo = 'minorista'): float
    {
        if ($tipo === 'mayorista') {
            return $this->precio_base_mayorista;
        }
        return $this->precio_base_minorista;
    }
    
    // ==========================================
    // ACCESORES (FORMATO DE PRECIOS)
    // ==========================================
    
    /**
     * Formatear precio minorista para mostrar en la vista.
     */
    public function getPrecioMinoristaFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_base_minorista, 2);
    }
    
    /**
     * Formatear precio mayorista para mostrar en la vista.
     */
    public function getPrecioMayoristaFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_base_mayorista, 2);
    }

    // ==========================================
    // SCOPES (FILTROS)
    // ==========================================

    /**
     * Filtrar estilos que tengan precios válidos.
     */
    public function scopeConPrecios($query)
    {
        return $query->where('precio_base_minorista', '>', 0)
                     ->orWhere('precio_base_mayorista', '>', 0);
    }

    /**
     * Buscar por nombre (búsqueda parcial).
     */
    public function scopeNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }
}