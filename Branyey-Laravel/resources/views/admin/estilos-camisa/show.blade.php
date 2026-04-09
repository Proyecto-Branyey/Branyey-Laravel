@extends('layouts.admin')

@section('title', $estilo->nombre . ' - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-brush me-2 text-secondary"></i>{{ $estilo->nombre }}
            </h1>
            <p class="text-muted small mb-0">Detalle completo del estilo de camisa</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.estilos-camisa.edit', $estilo->id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('admin.estilos-camisa.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    {{-- Tarjeta principal --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <span class="text-muted small text-uppercase fw-semibold">
                <i class="bi bi-info-circle me-1"></i> Información del estilo
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <table class="info-table">
                        <tr>
                            <td class="label">Nombre</td>
                            <td class="value">{{ $estilo->nombre }}</td>
                        </tr>
                        <tr>
                            <td class="label">ID</td>
                            <td class="value">#{{ $estilo->id }}</td>
                        </tr>
                        <tr>
                            <td class="label">Creado</td>
                            <td class="value">{{ $estilo->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Actualizado</td>
                            <td class="value">{{ $estilo->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Estado</td>
                            <td class="value">
                                @if($estilo->activo)
                                    <span class="badge bg-light text-success border">Activo</span>
                                @else
                                    <span class="badge bg-light text-danger border">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Productos asociados --}}
    @if($estilo->productos->count() > 0)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small text-uppercase fw-semibold">
                    <i class="bi bi-box-seam me-1"></i> Productos asociados
                </span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $estilo->productos->count() }} productos</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-end pe-4" style="width: 100px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estilo->productos as $producto)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $producto->id }}</td>
                            <td class="fw-semibold">{{ $producto->nombre_comercial ?? $producto->nombre }}</td>
                            <td>
                                <span class="text-muted small">{{ Str::limit($producto->descripcion ?? 'Sin descripción', 60) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.productos.show', $producto->id) }}" class="btn btn-sm btn-outline-secondary" title="Ver producto">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
        <div class="card-body p-4 text-center text-muted">
            <i class="bi bi-box-seam fs-2 d-block mb-2 opacity-50"></i>
            <p class="mb-0">No hay productos asociados a este estilo</p>
        </div>
    </div>
    @endif
</div>

<style>
/* Estilos consistentes */
.info-table {
    width: 100%;
}

.info-table tr {
    border-bottom: 1px solid #f0f0f0;
}

.info-table td {
    padding: 0.75rem 0;
}

.info-table .label {
    width: 140px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.info-table .value {
    font-size: 0.85rem;
    color: #1a1a2e;
}

.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.card {
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.table-light th {
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.badge.bg-light {
    background-color: #f8f9fa !important;
    font-weight: 500;
}
</style>
@endsection