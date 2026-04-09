@extends('layouts.admin')

@section('title', 'Gestión de Tallas - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-rulers me-2 text-secondary"></i>Gestión de Tallas
            </h1>
            <p class="text-muted small mb-0">Administra las tallas disponibles en el catálogo</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.tallas.papelera') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-trash3 me-1"></i> Papelera
            </a>
            <a href="{{ route('admin.tallas.create') }}" class="btn btn-dark btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Nueva Talla
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
                <span class="text-muted small text-uppercase fw-semibold">Listado de tallas</span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $tallas->count() }} registros</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Talla</th>
                        <th>Clasificación</th>
                        <th class="text-end pe-4" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tallas as $talla)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $talla->id }}</td>
                            <td class="fw-semibold">{{ $talla->nombre }}</td>
                            <td>
                                <span class="badge bg-light text-secondary border">{{ $talla->clasificacion?->nombre ?? 'Sin clasificación' }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.tallas.edit', $talla) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.tallas.destroy', $talla) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta talla? Se moverá a la papelera.')" title="Eliminar">
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
                                No hay tallas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection