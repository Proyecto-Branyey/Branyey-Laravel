<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Talla extends Model
{
    protected $table = 'tallas';
    
    protected $fillable = [
        'nombre',
        'clasificacion_id'
    ];
    
    protected $casts = [
        //
    ];

    // Se eliminó SoftDeletes y la propiedad $dates para evitar conflictos con la DB
    
    public function variantes()
    {
        return $this->hasMany(Variante::class);
    }

    public function clasificacion(): BelongsTo
    {
        return $this->belongsTo(ClasificacionTalla::class, 'clasificacion_id');
    }
    
    // Scope para ordenar (Ajustado para mayor compatibilidad)
    public function scopeOrdenNatural($query)
    {
        return $query->orderBy('nombre', 'asc');
    }
}