@extends('layouts.admin')

@section('admin-content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">{{ $estilo->nombre }}</h1>
                <div>
                    <a href="{{ route('admin.estilos-camisa.edit', $estilo->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('admin.estilos-camisa.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-muted">Información del Estilo</h5>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td>{{ $estilo->nombre }}</td>
                        </tr>
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $estilo->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Creado:</strong></td>
                            <td>{{ $estilo->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Actualizado:</strong></td>
                            <td>{{ $estilo->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($estilo->productos->count() > 0)
                <h5 class="text-muted mt-4">Productos con este Estilo ({{ $estilo->productos->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estilo->productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ Str::limit($producto->descripcion, 50) }}</td>
                                    <td>
                                        <a href="{{ route('admin.productos.show', $producto->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mt-4">
                    <i class="bi bi-info-circle"></i> No hay productos con este estilo.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
