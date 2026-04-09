@extends('layouts.admin')

@section('title', 'Gestión de Colores - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-palette me-2 text-secondary"></i>Gestión de Colores
            </h1>
            <p class="text-muted small mb-0">Administra los colores disponibles en el catálogo</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.colores.papelera') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-trash3 me-1"></i> Papelera
            </a>
            <a href="{{ route('admin.colores.create') }}" class="btn btn-dark btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Color
            </a>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 p-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 p-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small text-uppercase fw-semibold">Listado de colores</span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $colores->count() }} registros</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th style="width: 200px;">Color</th>
                        <th>Código Hex</th>
                        <th class="text-end pe-4" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($colores as $colore)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $colore->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="color-preview" style="background: {{ $colore->codigo_hex ?? '#6c757d' }};"></span>
                                    <span class="fw-semibold">{{ $colore->nombre }}</span>
                                </div>
                            </td>
                            <td>
                                <code class="bg-light px-2 py-1 rounded text-secondary">{{ $colore->codigo_hex ?? 'No definido' }}</code>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.colores.edit', $colore) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.colores.destroy', $colore) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este color? Se moverá a la papelera.')" title="Eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No hay colores registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.color-preview {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-block;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* Estilos para mantener consistencia */
.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-outline-danger {
    border-color: #dee2e6;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.btn-dark {
    background-color: #212529;
    border-color: #212529;
}

.btn-dark:hover {
    background-color: #1a1a2e;
    border-color: #1a1a2e;
}

.alert {
    border: none;
}

code {
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
}
</style>
@endsection