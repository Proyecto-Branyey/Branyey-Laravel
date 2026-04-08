@extends('layouts.admin')

@section('title', 'Papelera de Colores - Branyey')

@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-trash3 me-2"></i>Papelera de Colores</h2>
        <a href="{{ route('admin.colores.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colores as $color)
                            <tr>
                                <td>{{ $color->id }}</td>
                                <td>{{ $color->nombre }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="display:inline-block;width:18px;height:18px;border:1px solid #ccc;background:{{ $color->codigo_hex ?? '#000000' }};"></span>
                                        <span>{{ $color->codigo_hex ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.colores.activar', $color->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Reactivar este color?')">
                                            <i class="bi bi-arrow-clockwise me-1"></i> Reactivar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay colores inactivos en la papelera.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
