@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-trash3 me-2"></i>Papelera de Productos</h2>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-dark shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Volver al Inventario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>¡Hecho!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Imagen Principal</th>
                        <th>Producto</th>
                        <th>Estilo</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                    <tr>
                        <td class="ps-4">
                            @php $img = $producto->imagenes->where('es_principal', true)->first(); @endphp
                            @if($img)
                                <img src="{{ asset('storage/' . $img->url) }}" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="d-block p-2 rounded-2 fw-bold text-dark text-decoration-none position-relative">
                                {{ $producto->nombre_comercial }}
                                <small class="text-muted d-block fw-normal" style="font-size: 0.85em;">ID: #{{ $producto->id }}</small>
                            </span>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary border">{{ $producto->estilo?->nombre ?? 'Sin estilo' }}</span></td>
                        <td><span class="badge bg-danger-subtle text-danger">Inactivo</span></td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.productos.activar', $producto->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-sm btn-success border" title="Reactivar producto">
                                    <i class="bi bi-arrow-repeat"></i> Reactivar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No hay productos inactivos en la papelera.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
