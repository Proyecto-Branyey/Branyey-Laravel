@extends('layouts.admin')

@section('title', $producto->nombre_comercial . ' - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-box-seam me-2"></i>{{ $producto->nombre_comercial }}
            </h1>
            <p class="text-muted small mb-0">Detalle completo del producto y sus variantes</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn-action-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('admin.productos.index') }}" class="btn-action-outline">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    {{-- Tarjeta principal --}}
    <div class="product-detail-card">
        {{-- Información básica --}}
        <div class="info-summary">
            <div class="info-summary-item">
                <span class="label">ID Producto</span>
                <span class="value">#{{ $producto->id }}</span>
            </div>
            <div class="info-summary-item">
                <span class="label">Estilo</span>
                <span class="value">{{ $producto->estilo?->nombre ?? 'Sin estilo' }}</span>
            </div>
            <div class="info-summary-item">
                <span class="label">Clasificación</span>
                <span class="value">{{ $producto->clasificacionTalla?->nombre ?? 'N/A' }}</span>
            </div>
            <div class="info-summary-item">
                <span class="label">Estado</span>
                <span class="value {{ $producto->activo ? 'text-success' : 'text-muted' }}">
                    <i class="bi {{ $producto->activo ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-1"></i>
                    {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
            <div class="info-summary-item">
                <span class="label">Variantes</span>
                <span class="value">{{ $producto->variantes->count() }}</span>
            </div>
            <div class="info-summary-item">
                <span class="label">Total Stock</span>
                <span class="value">{{ $producto->variantes->sum('stock') }} unidades</span>
            </div>
        </div>

        {{-- Descripción --}}
        @if($producto->descripcion)
        <div class="description-box">
            <div class="description-label">Descripción</div>
            <div class="description-text">{{ $producto->descripcion }}</div>
        </div>
        @endif

        {{-- Tabla de Variantes con Imagen --}}
        <div class="variants-section">
            <div class="variants-header">
                <h6><i class="bi bi-table me-2"></i>Variantes del producto</h6>
                <span class="variants-count">{{ $producto->variantes->count() }} registros</span>
            </div>
            
            <div class="table-responsive">
                <table class="variants-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Precio Minorista</th>
                            <th>Precio Mayorista</th>
                            <th>Stock</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($producto->variantes as $variante)
                            @php
                                $color = $variante->colores->first();
                                $imagen = $producto->imagenes->firstWhere('color_id', $color?->id);
                                $hasImage = $imagen ? true : false;
                            @endphp
                            <tr>
                                <td class="col-image">
                                    @if($hasImage)
                                        <img src="{{ Storage::url($imagen->url) }}" class="variant-image" alt="{{ $color?->nombre }}">
                                    @else
                                        <div class="variant-image-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="col-color">
                                    <div class="color-info">
                                        <span class="color-dot" style="background: {{ $color?->codigo_hex ?? '#6c757d' }};"></span>
                                        <span>{{ $color?->nombre ?? 'Sin color' }}</span>
                                    </div>
                                </td>
                                <td class="col-size"><strong>{{ $variante->talla?->nombre ?? 'Sin talla' }}</strong></td>
                                <td class="col-price">${{ number_format($variante->precio_minorista, 0, ',', '.') }} COP</td>
                                <td class="col-price">${{ number_format($variante->precio_mayorista, 0, ',', '.') }} COP</td>
                                <td class="col-stock">
                                    @if($variante->stock > 0)
                                        <span class="stock-badge available">{{ $variante->stock }} uds</span>
                                    @else
                                        <span class="stock-badge out">Agotado</span>
                                    @endif
                                </td>
                                <td class="col-status">
                                    @if($hasImage)
                                        <span class="status-badge success">Completa</span>
                                    @else
                                        <span class="status-badge warning">
                                            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="link-warning">Sin imagen</a>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Galería de imágenes por color --}}
        <div class="gallery-section">
            <div class="gallery-header">
                <h6><i class="bi bi-images me-2"></i>Galería de imágenes por color</h6>
                <span class="gallery-count">{{ $producto->imagenes->count() }} imágenes</span>
            </div>
            
            @if($producto->imagenes->count() > 0)
                <div class="image-gallery">
                    @foreach($producto->imagenes as $imagen)
                        <div class="image-card">
                            <img src="{{ Storage::url($imagen->url) }}" class="image-preview" alt="{{ $producto->nombre_comercial }}">
                            <div class="image-info">
                                <span class="color-badge" style="background: {{ $imagen->color?->codigo_hex ?? '#6c757d' }};">
                                    {{ $imagen->color?->nombre ?? 'Sin color' }}
                                </span>
                                @if($imagen->es_principal)
                                    <span class="principal-badge">Principal</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-image-state">
                    <i class="bi bi-image"></i>
                    <p>Este producto no tiene imágenes registradas</p>
                    <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn-edit-small">
                        <i class="bi bi-plus-circle me-1"></i> Agregar imágenes
                    </a>
                </div>
            @endif
        </div>

        {{-- Resumen de stock por color --}}
        <div class="stock-summary">
            <div class="stock-summary-title">
                <i class="bi bi-pie-chart me-2"></i> Resumen por color
            </div>
            <div class="stock-summary-items">
                @php
                    $colorsSummary = [];
                    foreach($producto->variantes as $variante) {
                        $color = $variante->colores->first();
                        if($color) {
                            if(!isset($colorsSummary[$color->id])) {
                                $colorsSummary[$color->id] = [
                                    'nombre' => $color->nombre,
                                    'codigo_hex' => $color->codigo_hex,
                                    'stock' => 0,
                                    'variantes' => 0
                                ];
                            }
                            $colorsSummary[$color->id]['stock'] += $variante->stock;
                            $colorsSummary[$color->id]['variantes']++;
                        }
                    }
                @endphp
                @foreach($colorsSummary as $color)
                    <div class="stock-summary-card">
                        <span class="color-dot" style="background: {{ $color['codigo_hex'] ?? '#6c757d' }};"></span>
                        <span class="color-name">{{ $color['nombre'] }}</span>
                        <span class="color-stock">{{ $color['stock'] }} unidades</span>
                        <span class="color-variants">{{ $color['variantes'] }} tallas</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Footer acciones --}}
        <div class="product-footer">
            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="bi bi-trash3 me-2"></i> Enviar a papelera
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* ===== TARJETA PRINCIPAL ===== */
.product-detail-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* ===== INFO SUMMARY ===== */
.info-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: #fafbfc;
    border-bottom: 1px solid #e9ecef;
}

.info-summary-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-summary-item .label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
}

.info-summary-item .value {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1a1a2e;
}

/* ===== DESCRIPCIÓN ===== */
.description-box {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.description-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.description-text {
    font-size: 0.85rem;
    color: #495057;
    line-height: 1.5;
}

/* ===== TABLA DE VARIANTES ===== */
.variants-section {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.variants-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.variants-header h6 {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin: 0;
}

.variants-count {
    font-size: 0.7rem;
    background: #e9ecef;
    padding: 2px 8px;
    border-radius: 20px;
    color: #6c757d;
}

.variants-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
}

.variants-table th {
    padding: 0.75rem 0.5rem;
    text-align: left;
    background: #f8f9fa;
    font-weight: 700;
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom: 1px solid #e9ecef;
}

.variants-table td {
    padding: 0.75rem 0.5rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.variant-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 10px;
    background: #f8f9fa;
}

.variant-image-placeholder {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
}

.color-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.color-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
}

.stock-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
}

.stock-badge.available {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.stock-badge.out {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
}

.status-badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-badge.warning {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.link-warning {
    color: #ffc107;
    text-decoration: none;
}

.link-warning:hover {
    text-decoration: underline;
}

/* ===== GALERÍA DE IMÁGENES ===== */
.gallery-section {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.gallery-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.gallery-header h6 {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin: 0;
}

.gallery-count {
    font-size: 0.7rem;
    background: #e9ecef;
    padding: 2px 8px;
    border-radius: 20px;
    color: #6c757d;
}

.image-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.image-card {
    width: 140px;
    background: #f8f9fa;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.image-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.image-preview {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.image-info {
    padding: 8px 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    background: white;
}

.color-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    color: white;
    text-shadow: 0 0 2px rgba(0,0,0,0.3);
}

.principal-badge {
    background: #1a1a2e;
    color: white;
    padding: 2px 6px;
    border-radius: 12px;
    font-size: 0.6rem;
    font-weight: 600;
}

.empty-image-state {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 16px;
    color: #6c757d;
}

.empty-image-state i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    opacity: 0.5;
}

.btn-edit-small {
    display: inline-block;
    margin-top: 0.5rem;
    padding: 0.3rem 1rem;
    background: #667eea;
    color: white;
    border-radius: 20px;
    font-size: 0.7rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-edit-small:hover {
    background: #764ba2;
    color: white;
}

/* ===== RESUMEN POR COLOR ===== */
.stock-summary {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
}

.stock-summary-title {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 1rem;
}

.stock-summary-items {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.stock-summary-card {
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #e9ecef;
}

.stock-summary-card .color-name {
    font-weight: 600;
    font-size: 0.8rem;
}

.stock-summary-card .color-stock {
    font-size: 0.7rem;
    color: #10b981;
    font-weight: 600;
}

.stock-summary-card .color-variants {
    font-size: 0.65rem;
    color: #6c757d;
}

/* ===== FOOTER ===== */
.product-footer {
    padding: 1rem 1.5rem;
    background: white;
    display: flex;
    justify-content: flex-end;
}

.btn-delete {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: transparent;
    color: #dc3545;
    border: 1.5px solid #dc3545;
    border-radius: 40px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-delete:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-1px);
}

/* ===== BOTONES PRINCIPALES ===== */
.btn-action-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-primary:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: translateY(-1px);
    color: white;
}

.btn-action-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-outline:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .info-summary {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .variants-table {
        font-size: 0.7rem;
    }
    
    .image-card {
        width: calc(50% - 0.5rem);
    }
    
    .stock-summary-items {
        flex-direction: column;
    }
    
    .stock-summary-card {
        justify-content: space-between;
        width: 100%;
    }
    
    .product-footer {
        justify-content: center;
    }
}
</style>
@endsection