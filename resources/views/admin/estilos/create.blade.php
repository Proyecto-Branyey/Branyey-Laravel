@extends('layouts.app')

@section('title', 'Nuevo Estilo - Admin Branyey')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Nuevo Estilo</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.estilos.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Estilo</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Precio Minorista ($)</label>
                                <input type="number" name="precio_base_minorista" class="form-control" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Precio Mayorista ($)</label>
                                <input type="number" name="precio_base_mayorista" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-save me-2"></i> Guardar Estilo
                            </button>
                            <a href="{{ route('admin.estilos.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection