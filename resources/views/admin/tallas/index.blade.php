@extends('layouts.app')

@section('title', 'Gestión de Tallas - Branyey')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-rulers me-2"></i>Gestión de Tallas</h2>
        <a href="{{ route('admin.tallas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nueva Talla
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
                            <th>Clasificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tallas as $talla)
                            <tr>
                                <td>{{ $talla->id }}</td>
                                <td>{{ $talla->nombre }}</td>
                                <td>{{ $talla->clasificacion?->nombre ?? 'Sin clasificación' }}</td>
                                <td>
                                    <a href="{{ route('admin.tallas.edit', $talla) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.tallas.destroy', $talla) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta talla?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No hay tallas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection