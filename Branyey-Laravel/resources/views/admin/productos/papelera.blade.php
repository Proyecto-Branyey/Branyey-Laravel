@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-trash3-fill me-2"></i>Papelera de Productos
            </h1>
            <p class="text-muted small mb-0">Productos desactivados que pueden ser reactivados</p>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver al Inventario
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert-success-card mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabla de productos inactivos --}}
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-image">Imagen</th>
                    <th class="col-product">Producto</th>
                    <th class="col-style">Estilo</th>
                    <th class="col-status">Estado</th>
                    <th class="col-actions">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td class="col-image">
                            @php $img = $producto->imagenes->where('es_principal', true)->first() ?? $producto->imagenes->first(); @endphp
                            @if($img)
                                <img src="{{ Storage::url($img->url) }}" class="product-image" alt="{{ $producto->nombre_comercial }}">
                            @else
                                <div class="product-image-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="col-product">
                            <div class="product-cell">
                                <div>
                                    <span class="product-title">{{ $producto->nombre_comercial }}</span>
                                    <div class="product-id">ID: #{{ $producto->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="col-style">
                            <span class="style-badge">{{ $producto->estilo?->nombre ?? 'Sin estilo' }}</span>
                        </td>
                        <td class="col-status">
                            <span class="status-badge inactive">
                                <i class="bi bi-x-circle-fill me-1"></i> Inactivo
                            </span>
                        </td>
                        <td class="col-actions">
                            <form action="{{ route('admin.productos.activar', $producto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="action-btn restore" onclick="return confirm('¿Reactivar este producto? Se reactivarán también todas sus variantes.')" title="Reactivar">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Reactivar</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state-cell">
                            <div class="empty-state">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="mt-3 mb-0">No hay productos inactivos en la papelera</p>
                                <small class="text-muted">Los productos desactivados aparecerán aquí</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* ===== TABLA ===== */
.table-container {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    padding: 1rem 1rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.85rem;
}

.admin-table tr:hover {
    background: #fafbfc;
}

/* Columnas específicas */
.col-image { width: 80px; }
.col-product { width: auto; }
.col-style { width: 120px; }
.col-status { width: 100px; }
.col-actions { width: 120px; }

/* ===== PRODUCTO ===== */
.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.product-image-placeholder {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    border: 1px solid #e9ecef;
}

.product-image-placeholder i {
    font-size: 1.5rem;
}

.product-cell {
    display: flex;
    flex-direction: column;
}

.product-title {
    font-weight: 700;
    color: #1a1a2e;
}

.product-id {
    font-size: 0.7rem;
    color: #6c757d;
    margin-top: 4px;
}

/* ===== BADGES ===== */
.style-badge {
    display: inline-block;
    padding: 4px 10px;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-badge.inactive {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

/* ===== BOTONES ===== */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border: none;
    border-radius: 40px;
    font-size: 0.7rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.action-btn:hover {
    background: #10b981;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* ===== ALERTAS ===== */
.alert-success-card, .alert-error-card {
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.alert-success-card {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-left: 3px solid #10b981;
}

.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-left: 3px solid #dc3545;
}

/* ===== BOTÓN VOLVER ===== */
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

/* ===== EMPTY STATE ===== */
.empty-state-cell {
    text-align: center !important;
    padding: 3rem !important;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    opacity: 0.5;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
    
    .col-image, .col-product, .col-style, .col-status, .col-actions {
        min-width: 100px;
    }
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .action-btn span {
        display: none;
    }
    
    .action-btn {
        padding: 0.5rem;
    }
}
</style>
@endsection