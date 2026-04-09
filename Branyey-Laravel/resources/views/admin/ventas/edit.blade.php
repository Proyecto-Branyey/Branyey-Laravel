@extends('layouts.admin')

@section('title', 'Editar Venta - Branyey')

@section('admin-content')
<div class="container-fluid px-4 py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-pencil-square me-2"></i>Editar Venta
            </h1>
            <p class="text-muted small mb-0">Modifica la información de la venta #{{ $venta->id ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('admin.ventas.index') }}" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Tarjeta de edición --}}
    <div class="form-card">
        <form method="POST" action="{{ route('admin.ventas.update', $venta->id ?? 1) }}" id="ventaForm">
            @csrf
            @method('PUT')

            {{-- Sección 1: Información del cliente --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-person-circle"></i>
                    <h5>Información del cliente</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cliente_id" class="form-label">
                                <i class="bi bi-person-badge me-1"></i>Cliente <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="cliente_id" name="cliente_id" required>
                                <option value="">Seleccione un cliente</option>
                                {{-- Opciones de clientes --}}
                            </select>
                            <div class="form-hint">
                                <i class="bi bi-info-circle me-1"></i>Selecciona el cliente asociado a esta venta
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 2: Detalles de la venta --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-receipt"></i>
                    <h5>Detalles de la venta</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha" class="form-label">
                                <i class="bi bi-calendar me-1"></i>Fecha
                            </label>
                            <input type="date" class="form-input" id="fecha" name="fecha" value="{{ $venta->created_at->format('Y-m-d') ?? date('Y-m-d') }}">
                            <div class="form-hint">
                                <i class="bi bi-info-circle me-1"></i>Fecha de la transacción
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total" class="form-label">
                                <i class="bi bi-currency-dollar me-1"></i>Total <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-input" id="total" name="total" value="{{ $venta->total ?? '0.00' }}" required>
                            <div class="form-hint">
                                <i class="bi bi-info-circle me-1"></i>Monto total de la venta
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 3: Estado de la venta --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-flag"></i>
                    <h5>Estado de la venta</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado" class="form-label">
                                <i class="bi bi-tag me-1"></i>Estado actual
                            </label>
                            <div class="status-display">
                                <span class="status-badge status-{{ $venta->estado ?? 'pagado' }}">
                                    {{ ucfirst(str_replace('_', ' ', $venta->estado ?? 'Pagado')) }}
                                </span>
                            </div>
                            <div class="form-hint">
                                <i class="bi bi-info-circle me-1"></i>El estado se puede cambiar desde el listado de ventas
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-calendar-check me-1"></i>Última actualización
                            </label>
                            <div class="info-display">
                                {{ $venta->updated_at->format('d/m/Y H:i:s') ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 4: Productos --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-box-seam"></i>
                    <h5>Productos</h5>
                </div>
                
                <div class="alert-info-card mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Los productos se gestionan desde la vista de detalles de la venta.
                </div>
            </div>

            {{-- Botones --}}
            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="bi bi-save2 me-2"></i> Actualizar venta
                </button>
                <a href="{{ route('admin.ventas.index') }}" class="btn-cancel">
                    <i class="bi bi-x-lg me-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* ===== FORM CARD ===== */
.form-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
}

.section-header i {
    font-size: 1.2rem;
    color: #667eea;
}

.section-header h5 {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin: 0;
}

/* ===== FORM GROUPS ===== */
.form-group {
    margin-bottom: 0.25rem;
}

.form-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.form-input, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== STATUS DISPLAY ===== */
.status-display {
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border-radius: 16px;
    border: 1px solid #e9ecef;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pagado { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.status-en_proceso { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
.status-enviado { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
.status-entregado { background: rgba(13, 202, 240, 0.1); color: #0dcaf0; }
.status-cancelado { background: rgba(220, 53, 69, 0.1); color: #dc3545; }

.info-display {
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border-radius: 16px;
    border: 1px solid #e9ecef;
    font-size: 0.85rem;
    color: #1a1a2e;
}

/* ===== ALERTA INFORMATIVA ===== */
.alert-info-card {
    background: rgba(13, 110, 253, 0.08);
    color: #0d6efd;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    border-left: 3px solid #0d6efd;
}

/* ===== BOTONES ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.75rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-save:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea, #764ba2);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
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
    .form-card {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-save, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection