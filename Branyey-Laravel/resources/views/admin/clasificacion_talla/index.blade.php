@extends('layouts.admin')

@section('title', 'Gestión de Clasificación de Talla - Branyey')

@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-tags me-2 text-secondary"></i>Gestión de Clasificación de Talla
            </h1>
            <p class="text-muted small mb-0">Administra las clasificaciones de talla disponibles</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.clasificacion-talla.create') }}" class="btn btn-dark btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Nueva Clasificación
            </a>
            <!-- Botón Importar -->
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#importarClasificacionForm" aria-expanded="false" aria-controls="importarClasificacionForm">
                <i class="bi bi-upload me-1"></i> Importar Clasificaciones
            </button>
        </div>
    </div>

    <!-- Formulario de importación (colapsable) -->
    <div class="collapse mb-3" id="importarClasificacionForm">
        <form action="{{ route('admin.importar.excel') }}" method="POST" enctype="multipart/form-data" class="card card-body border-0 shadow-sm gap-2">
            @csrf
            <input type="hidden" name="tabla" value="clasificacion-talla">
            <div class="mb-2">
                <label for="archivoClasificacion" class="form-label">Archivo Excel (.xlsx) de clasificaciones de talla</label>
                <input type="file" name="file" id="archivoClasificacion" class="form-control" accept=".xlsx" required>
            </div>
            <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-cloud-arrow-up me-1"></i> Cargar archivo
            </button>
        </form>
    </div>
    </div>

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

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small text-uppercase fw-semibold">Listado de clasificaciones</span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $clasificaciones->count() }} registros</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Nombre</th>
                        <th class="text-end pe-4" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clasificaciones as $clasificacion)
                        <tr>
                            <td class="ps-4">{{ $clasificacion->id }}</td>
                            <td>{{ $clasificacion->nombre }}</td>
                            <td class="text-end pe-4">
                                <!-- Acciones aquí -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
