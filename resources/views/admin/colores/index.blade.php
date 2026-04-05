@extends('layouts.app')

@section('title', 'Gestión de Colores - Branyey')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-palette me-2"></i>Gestión de Colores</h2>
        <a href="{{ route('admin.colores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Color
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Código Hex</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colores as $colore)
                            <tr>
                                <td>{{ $colore->id }}</td>
                                <td>{{ $colore->nombre }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="color-swatch me-2" style="width: 20px; height: 20px; background-color: {{ $colore->codigo_hex ?? '#000000' }}; border: 1px solid #ccc;"></div>
                                        {{ $colore->codigo_hex ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.colores.edit', $colore) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.colores.destroy', $colore) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este color?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay colores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection