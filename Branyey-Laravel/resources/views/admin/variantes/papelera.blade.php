@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-trash3-fill me-2"></i>Papelera de Variantes
            </h1>
            <p class="text-muted small mb-0">Variantes desactivadas que pueden ser reactivadas</p>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver al Inventario
        </a>
    </div>

    {{-- Alertas --}}
    @if($errors->has('error'))
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert-success-card mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de variantes inactivas --}}
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-sku">SKU</th>
                    <th class="col-product">Producto</th>
                    <th class="col-size">Talla</th>
                    <th class="col-status">Estado</th>
                    <th class="col-actions">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($variantes as $variante)
                    @php
                        $productoBloqueado = !$variante->producto || !$variante->producto->activo || $variante->producto->trashed();
                    @endphp
                    <tr>
                        <td class="col-sku">
                            <span class="sku-code">{{ $variante->sku }}</span>
                        </td>
                        <td class="col-product">
                            <div class="product-cell">
                                @if($variante->producto)
                                    <span class="product-name">{{ $variante->producto->nombre_comercial }}</span>
                                    <div class="product-id">ID: #{{ $variante->producto->id }}</div>
                                @else
                                    <span class="product-name text-muted">Producto no disponible</span>
                                @endif
                            </div>
                        </td>
                        <td class="col-size">
                            <span class="size-badge">{{ $variante->talla?->nombre ?? 'N/A' }}</span>
                        </td>
                        <td class="col-status">
                            <span class="status-badge inactive">
                                <i class="bi bi-trash3-fill me-1"></i> En papelera
                            </span>
                        </td>
                        <td class="col-actions">
                            @if($productoBloqueado)
                                <span class="blocked-warning" title="Primero reactiva el producto completo">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Reactivar producto primero
                                </span>
                            @else
                                <form action="{{ route('admin.variantes.activar', $variante->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="action-btn restore" onclick="return confirm('¿Reactivar esta variante?')" title="Reactivar variante">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        Reactivar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state-cell">
                            <div class="empty-state">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="mt-3 mb-0">No hay variantes en la papelera</p>
                                <small class="text-muted">Las variantes desactivadas aparecerán aquí</small>
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
    vertical-align: middle;
}

.admin-table tr:hover {
    background: #fafbfc;
}

/* Columnas específicas */
.col-sku { width: 160px; }
.col-product { width: auto; }
.col-size { width: 100px; }
.col-status { width: 130px; }
.col-actions { width: 200px; }

/* ===== SKU ===== */
.sku-code {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    font-size: 0.8rem;
    background: #f0f2f5;
    padding: 4px 8px;
    border-radius: 8px;
    letter-spacing: 0.5px;
}

/* ===== PRODUCTO ===== */
.product-cell {
    display: flex;
    flex-direction: column;
}

.product-name {
    font-weight: 700;
    color: #1a1a2e;
}

.product-id {
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 2px;
}

/* ===== TALLA ===== */
.size-badge {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* ===== BADGES ===== */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-badge.inactive {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* ===== BOTONES ===== */
.action-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
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

.blocked-warning {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    border-radius: 40px;
    font-size: 0.65rem;
    font-weight: 600;
    cursor: default;
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
    
    .col-sku, .col-product, .col-size, .col-status, .col-actions {
        min-width: 120px;
    }
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .action-btn, .blocked-warning {
        padding: 0.4rem 0.8rem;
        font-size: 0.6rem;
    }
}
</style>
@endsection