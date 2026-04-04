<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Producto extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'productos';

    /**
     * Indicamos que no usamos timestamps en esta tabla
     * porque no tiene created_at ni updated_at
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = [
        'estilo_id',
        'clasificacion_id',
        'nombre_comercial',
        'descripcion',
        'activo'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'activo' => 'boolean',
        'estilo_id' => 'integer',
        'clasificacion_id' => 'integer',
    ];

    // ==========================================
    // RELACIONES (Core de Branyey)
    // ==========================================

    /**
     * Relación: Un producto pertenece a un estilo de camisa (precios base).
     */
    public function estilo(): BelongsTo
    {
        return $this->belongsTo(EstiloCamisa::class, 'estilo_id');
    }

    /**
     * Relación: Un producto pertenece a una clasificación de talla (Men, Women, Kids).
     */
    public function clasificacion(): BelongsTo
    {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_id');
    }

    /**
     * Relación: Un producto tiene muchas variantes (combinaciones de Talla/Color/Stock).
     */
    public function variantes(): HasMany
    {
        return $this->hasMany(Variante::class, 'producto_id');
    }

    /**
     * Relación: Un producto tiene muchas imágenes asociadas.
     */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }

    // ==========================================
    // MÉTODOS DE LÓGICA Y ATRIBUTOS DINÁMICOS
    // ==========================================

    /**
     * Obtener la imagen de un color específico para la galería dinámica (HU-016).
     */
    public function getImagenPorColor(string $color): ?ImagenProducto
    {
        return $this->imagenes()
                    ->where('color', $color)
                    ->first();
    }

    /**
     * Accesor para obtener el mapa de Colores => URLs de imagen.
     */
    public function getColoresConImagenesAttribute(): array
    {
        return $this->imagenes->mapWithKeys(function ($imagen) {
            return [$imagen->color => $imagen->url];
        })->toArray();
    }

    /**
     * Obtener todas las tallas únicas disponibles para este producto (HU-004).
     */
    public function getTallasDisponiblesAttribute(): Collection
    {
        return $this->variantes()
                    ->with('talla')
                    ->get()
                    ->pluck('talla')
                    ->filter() // Seguridad: elimina nulos si una talla fue borrada
                    ->unique('id')
                    ->values();
    }

    /**
     * Obtener todos los nombres de colores disponibles cruzando Imágenes y Variantes.
     */
    public function getColoresDisponiblesAttribute(): Collection
    {
        // 1. Colores desde la tabla de imágenes
        $coloresImagenes = $this->imagenes->pluck('color')->unique();
        
        // 2. Colores desde la tabla pivot de variantes
        $coloresVariantes = $this->variantes()
            ->with('colores')
            ->get()
            ->flatMap(function ($variante) {
                return $variante->colores->pluck('nombre');
            })
            ->unique();

        // Fusionamos ambos para asegurar que no falte ningún color en la vista
        return $coloresImagenes->merge($coloresVariantes)
                               ->unique()
                               ->filter()
                               ->values();
    }

    /**
     * Determina si el producto tiene stock en alguna de sus variantes.
     */
    public function tieneStockDisponible(): bool
    {
        return $this->variantes()->where('stock', '>', 0)->exists();
    }

    // ==========================================
    // SCOPES (Filtros de Base de Datos)
    // ==========================================

    /**
     * FILTRO CRÍTICO: Solo productos marcados como activos Y con existencias reales.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true)
                     ->whereHas('variantes', function ($q) {
                         $q->where('stock', '>', 0);
                     });
    }

    public function scopePorEstilo($query, $estiloId)
    {
        if (!$estiloId) return $query;
        return $query->where('estilo_id', $estiloId);
    }

    public function scopePorClasificacion($query, $clasificacionId)
    {
        if (!$clasificacionId) return $query;
        return $query->where('clasificacion_id', $clasificacionId);
    }

    /**
     * Scope para buscar por nombre comercial (útil para la barra de búsqueda).
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre_comercial', 'like', "%{$termino}%");
    }
}