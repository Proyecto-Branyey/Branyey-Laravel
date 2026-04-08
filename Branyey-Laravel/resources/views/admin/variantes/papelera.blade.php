@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-trash3 me-2"></i>Papelera de Variantes</h2>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-dark shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver a Inventario
        </a>
    </div>

    @if($errors->has('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
            {{ $errors->first('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <strong>¡Hecho!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">SKU</th>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($variantes as $variante)
                        @php
                            $productoBloqueado = !$variante->producto || !$variante->producto->activo || $variante->producto->trashed();
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold">{{ $variante->sku }}</td>
                            <td>{{ $variante->producto?->nombre_comercial ?? 'Producto no disponible' }}</td>
                            <td>{{ $variante->talla?->nombre ?? 'N/A' }}</td>
                            <td><span class="badge bg-danger-subtle text-danger">En papelera</span></td>
                            <td class="text-end pe-4">
                                @if($productoBloqueado)
                                    <span class="badge bg-secondary">Reactivar producto completo primero</span>
                                @else
                                    <form action="{{ route('admin.variantes.activar', $variante->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success" title="Reactivar variante">
                                            <i class="bi bi-arrow-repeat"></i> Reactivar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay variantes en la papelera.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
