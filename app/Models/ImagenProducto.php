<?php
// app/Models/ImagenProducto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ImagenProducto extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'imagenes_producto';

    /**
     * La clave primaria asociada a la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_producto',
        'color',
        'url'
    ];

    /**
     * Los atributos que deben ser ocultados para arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id_producto' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * Los accesores a agregar al array del modelo.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'url_completa',
        'nombre_archivo',
        'extension',
        'existe_en_storage'
    ];

    // ==========================================
    // RELACIONES
    // ==========================================

    /**
     * Obtener el producto al que pertenece esta imagen.
     *
     * @return BelongsTo
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }

    // ==========================================
    // SCOPES (CONSULTAS PERSONALIZADAS)
    // ==========================================

    /**
     * Scope para filtrar imágenes por producto.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $productoId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorProducto($query, int $productoId)
    {
        return $query->where('id_producto', $productoId);
    }

    /**
     * Scope para filtrar imágenes por color.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $color
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorColor($query, string $color)
    {
        return $query->where('color', $color);
    }

    /**
     * Scope para buscar imágenes que existen físicamente.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExistenEnStorage($query)
    {
        // Este scope requiere lógica personalizada, se implementa en colección
        return $query;
    }

    // ==========================================
    // ACCESORES (GET)
    // ==========================================

    /**
     * Obtener la URL completa de la imagen.
     *
     * @return string
     */
    public function getUrlCompletaAttribute(): string
    {
        // Si la URL ya es completa (http), devolverla
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            return $this->url;
        }
        
        // Si es ruta absoluta de Windows, mantenerla
        if (preg_match('/^[A-Z]:\\\\/', $this->url)) {
            return $this->url;
        }
        
        // Si es ruta local, usar asset()
        return asset($this->url);
    }

    /**
     * Obtener solo el nombre del archivo de la ruta.
     *
     * @return string
     */
    public function getNombreArchivoAttribute(): string
    {
        return basename($this->url);
    }

    /**
     * Obtener la extensión del archivo.
     *
     * @return string
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->url, PATHINFO_EXTENSION);
    }

    /**
     * Obtener el directorio donde se encuentra la imagen.
     *
     * @return string
     */
    public function getDirectorioAttribute(): string
    {
        return dirname($this->url);
    }

    /**
     * Verificar si la imagen existe físicamente.
     *
     * @return bool
     */
    public function getExisteEnStorageAttribute(): bool
    {
        // Si es URL, no podemos verificar fácilmente
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            return true; // Asumimos que existe
        }
        
        // Si es ruta absoluta de Windows
        if (preg_match('/^[A-Z]:\\\\/', $this->url)) {
            return file_exists($this->url);
        }
        
        // Si es ruta relativa al storage
        $rutaStorage = str_replace('/storage/', '', $this->url);
        return Storage::disk('public')->exists($rutaStorage);
    }

    /**
     * Obtener el tamaño del archivo en bytes.
     *
     * @return int|null
     */
    public function getTamañoAttribute(): ?int
    {
        if ($this->existe_en_storage && file_exists($this->url)) {
            return filesize($this->url);
        }
        return null;
    }

    /**
     * Obtener el tamaño formateado (KB, MB).
     *
     * @return string|null
     */
    public function getTamañoFormateadoAttribute(): ?string
    {
        $bytes = $this->tamaño;
        if (!$bytes) return null;
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // ==========================================
    // MUTADORES (SET)
    // ==========================================

    /**
     * Normalizar la URL al guardar.
     *
     * @param  string  $value
     * @return void
     */
    public function setUrlAttribute($value)
    {
        // Normalizar separadores de directorios
        $this->attributes['url'] = str_replace('\\', '/', $value);
    }

    /**
     * Asegurar que el color tenga formato correcto.
     *
     * @param  string  $value
     * @return void
     */
    public function setColorAttribute($value)
    {
        $this->attributes['color'] = ucfirst(trim($value));
    }

    // ==========================================
    // MÉTODOS PERSONALIZADOS
    // ==========================================

    /**
     * Copiar la imagen a una nueva ubicación.
     *
     * @param  string  $nuevaRuta
     * @return bool
     */
    public function copiarA(string $nuevaRuta): bool
    {
        if (!$this->existe_en_storage) {
            return false;
        }
        
        return copy($this->url, $nuevaRuta);
    }

    /**
     * Mover la imagen a una nueva ubicación.
     *
     * @param  string  $nuevaRuta
     * @return bool
     */
    public function moverA(string $nuevaRuta): bool
    {
        if (!$this->existe_en_storage) {
            return false;
        }
        
        if (rename($this->url, $nuevaRuta)) {
            $this->update(['url' => $nuevaRuta]);
            return true;
        }
        
        return false;
    }

    /**
     * Eliminar el archivo físico.
     *
     * @return bool
     */
    public function eliminarArchivo(): bool
    {
        if (!$this->existe_en_storage) {
            return false;
        }
        
        return unlink($this->url);
    }

    /**
     * Obtener la imagen como base64.
     *
     * @return string|null
     */
    public function toBase64(): ?string
    {
        if (!$this->existe_en_storage) {
            return null;
        }
        
        $contenido = file_get_contents($this->url);
        if (!$contenido) {
            return null;
        }
        
        return 'data:' . mime_content_type($this->url) . ';base64,' . base64_encode($contenido);
    }

    /**
     * Verificar si el color está disponible en las variantes del producto.
     *
     * @return bool
     */
    public function colorEsValido(): bool
    {
        if (!$this->producto) {
            return false;
        }
        
        return $this->producto->variantes()
            ->where('color', $this->color)
            ->exists();
    }

    // ==========================================
    // EVENTOS DEL MODELO
    // ==========================================

    /**
     * Boot del modelo.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de crear
        static::creating(function ($imagen) {
            // Validar que el producto exista
            if (!Producto::find($imagen->id_producto)) {
                return false;
            }
        });

        // Después de crear
        static::created(function ($imagen) {
            // Aquí puedes agregar logs o notificaciones
        });

        // Antes de actualizar
        static::updating(function ($imagen) {
            // Validaciones antes de actualizar
        });

        // Antes de eliminar
        static::deleting(function ($imagen) {
            // Opcional: eliminar el archivo físico automáticamente
            // $imagen->eliminarArchivo();
        });

        // Después de eliminar
        static::deleted(function ($imagen) {
            // Limpiar caché si es necesario
        });
    }

    // ==========================================
    // MÉTODOS ESTÁTICOS DE AYUDA
    // ==========================================

    /**
     * Sincronizar imágenes para un producto.
     *
     * @param  int  $productoId
     * @param  array  $imagenes  [color => ruta]
     * @return void
     */
    public static function sincronizar(int $productoId, array $imagenes): void
    {
        // Eliminar imágenes que no están en el nuevo array
        $coloresExistentes = self::where('id_producto', $productoId)
            ->pluck('color')
            ->toArray();
        
        $coloresNuevos = array_keys($imagenes);
        
        // Eliminar colores que ya no están
        $coloresAEliminar = array_diff($coloresExistentes, $coloresNuevos);
        if (!empty($coloresAEliminar)) {
            self::where('id_producto', $productoId)
                ->whereIn('color', $coloresAEliminar)
                ->delete();
        }
        
        // Actualizar o crear nuevas
        foreach ($imagenes as $color => $url) {
            self::updateOrCreate(
                [
                    'id_producto' => $productoId,
                    'color' => $color
                ],
                [
                    'url' => $url
                ]
            );
        }
    }

    /**
     * Obtener todas las imágenes agrupadas por producto.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function agrupadasPorProducto()
    {
        return self::with('producto')
            ->get()
            ->groupBy('id_producto');
    }
}