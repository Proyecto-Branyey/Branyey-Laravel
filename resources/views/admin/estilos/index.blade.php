@extends('layouts.app')

@section('title', 'Estilos - Admin Branyey')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Gestión de Estilos</h2>
        <a href="{{ route('admin.estilos.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-circle me-2"></i> Nuevo Estilo
        </a>
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
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
                                <a href="{{ route('admin.estilos.edit', $estilo->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('admin.estilos.destroy', $estilo->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este estilo?')">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <p class="text-muted mb-0">No hay estilos registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection