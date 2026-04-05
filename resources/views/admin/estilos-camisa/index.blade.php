@extends('layouts.app')

@section('title', 'Gestión de Estilos - Branyey')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-brush me-2"></i>Gestión de Estilos</h2>
        <a href="{{ route('admin.estilos-camisa.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Estilo
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estilos as $estilo)
                            <tr>
                                <td>{{ $estilo->id }}</td>
                                <td>{{ $estilo->nombre }}</td>
                                <td>
                                    <a href="{{ route('admin.estilos-camisa.show', $estilo) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('admin.estilos-camisa.edit', $estilo) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.estilos-camisa.destroy', $estilo) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este estilo?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay estilos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection