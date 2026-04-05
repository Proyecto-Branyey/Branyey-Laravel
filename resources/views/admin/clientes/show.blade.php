@extends('layouts.admin')

@section('title', $cliente->username . ' - Admin')

@section('admin-content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-dark text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold">{{ $cliente->username }}</h3>
                        <a href="{{ route('admin.clientes.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Nombre completo</h6>
                            <p class="fw-bold">{{ $cliente->nombre_completo ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Rol</h6>
                            <p class="fw-bold">{{ $cliente->rol?->nombre ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Email</h6>
                            <p class="fw-bold">{{ $cliente->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Teléfono</h6>
                            <p class="fw-bold">{{ $cliente->telefono ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Dirección</h6>
                            <p class="fw-bold">{{ $cliente->direccion_defecto ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Ciudad</h6>
                            <p class="fw-bold">{{ $cliente->ciudad_defecto ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Departamento</h6>
                            <p class="fw-bold">{{ $cliente->departamento_defecto ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Editar</a>
                        <form action="{{ route('admin.clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
