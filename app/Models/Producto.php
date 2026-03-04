<?php
// app/Models/Producto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'productos';

    /**
     * Indicamos que no usamos timestamps en esta tabla
     * porque no tiene created_at ni updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
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
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación: Un producto pertenece a un estilo de camisa.
     */
    public function estilo(): BelongsTo
    {
        return $this->belongsTo(EstiloCamisa::class, 'estilo_id');
    }

    /**
     * Relación: Un producto pertenece a una clasificación de talla.
     */
    public function clasificacion(): BelongsTo
    {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_id');
    }

    /**
     * Relación: Un producto tiene muchas variantes (tallas).
     */
    public function variantes(): HasMany
    {
        return $this->hasMany(Variante::class, 'producto_id');
    }

    /**
     * Relación: Un producto tiene muchas imágenes.
     */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }

    /**
     * Obtener la imagen de un color específico.
     */
    public function getImagenPorColor(string $color): ?ImagenProducto
    {
        return $this->imagenes()
                    ->where('color', $color)
                    ->first();
    }

    /**
     * Obtener todos los colores disponibles con sus imágenes.
     */
    public function getColoresConImagenesAttribute()
    {
        return $this->imagenes->mapWithKeys(function ($imagen) {
            return [$imagen->color => $imagen->url];
        })->toArray();
    }

    /**
     * Obtener todas las tallas disponibles para este producto.
     */
    public function getTallasDisponiblesAttribute()
    {
        return $this->variantes()
                    ->with('talla')
                    ->get()
                    ->pluck('talla')
                    ->unique('id')
                    ->values();
    }

    /**
     * Obtener todos los colores disponibles (desde imágenes y variantes).
     */
    public function getColoresDisponiblesAttribute()
    {
        // Colores desde imágenes
        $coloresImagenes = $this->imagenes->pluck('color')->unique();
        
        // Colores desde variantes
        $coloresVariantes = $this->variantes()
            ->with('colores')
            ->get()
            ->flatMap(function ($variante) {
                return $variante->colores->pluck('nombre');
            })
            ->unique();

        return $coloresImagenes->merge($coloresVariantes)->unique()->values();
    }

    /**
     * Scope para filtrar productos activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para filtrar por estilo.
     */
    public function scopePorEstilo($query, $estiloId)
    {
        return $query->where('estilo_id', $estiloId);
    }

    /**
     * Scope para filtrar por clasificación.
     */
    public function scopePorClasificacion($query, $clasificacionId)
    {
        return $query->where('clasificacion_id', $clasificacionId);
    }
}   