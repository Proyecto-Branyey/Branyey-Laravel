@extends('layouts.admin')

@section('title', 'Papelera de Estilos - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-trash3-fill me-2 text-secondary"></i>Papelera de Estilos
            </h1>
            <p class="text-muted small mb-0">Estilos desactivados que pueden ser reactivados</p>
        </div>
        <a href="{{ route('admin.estilos-camisa.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
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
                <span class="text-muted small text-uppercase fw-semibold">
                    <i class="bi bi-trash3 me-1"></i> Listado de estilos inactivos
                </span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $estilos->count() }} registros</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Nombre del estilo</th>
                        <th class="text-end pe-4" style="width: 130px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estilos as $estilo)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $estilo->id }}</td>
                            <td class="fw-semibold">{{ $estilo->nombre }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.estilos-camisa.activar', $estilo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('¿Reactivar este estilo?')" title="Reactivar">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Reactivar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No hay estilos en la papelera
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Estilos consistentes */
.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-outline-success {
    border-color: #dee2e6;
    color: #198754;
}

.btn-outline-success:hover {
    background-color: #198754;
    border-color: #198754;
    color: white;
}

.alert {
    border: none;
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
</style>
@endsection