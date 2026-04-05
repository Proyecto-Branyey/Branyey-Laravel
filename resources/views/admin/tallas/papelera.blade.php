@extends('layouts.admin')

@section('title', 'Papelera de Tallas - Branyey')

@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-trash3 me-2"></i>Papelera de Tallas</h2>
        <a href="{{ route('admin.tallas.index') }}" class="btn btn-outline-secondary">
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
                            <th>Clasificacion</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tallas as $talla)
                            <tr>
                                <td>{{ $talla->id }}</td>
                                <td>{{ $talla->nombre }}</td>
                                <td>{{ $talla->clasificacion?->nombre ?? 'Sin clasificacion' }}</td>
                                <td>
                                    <form action="{{ route('admin.tallas.activar', $talla->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Reactivar esta talla?')">
                                            <i class="bi bi-arrow-clockwise me-1"></i> Reactivar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay tallas inactivas en la papelera.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
