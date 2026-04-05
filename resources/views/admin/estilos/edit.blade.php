@extends('layouts.app')

@section('title', 'Editar Estilo - Admin Branyey')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i> Editar Estilo</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.estilos.update', $estilo->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Estilo</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $estilo->nombre }}" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-save me-2"></i> Actualizar Estilo
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