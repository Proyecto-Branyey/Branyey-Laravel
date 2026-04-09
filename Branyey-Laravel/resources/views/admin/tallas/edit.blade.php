@extends('layouts.admin')

@section('title', 'Editar Talla - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-pencil-square me-2 text-secondary"></i>Editar Talla
            </h1>
            <p class="text-muted small mb-0">Modifica la información de la talla</p>
        </div>
        <a href="{{ route('admin.tallas.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Formulario --}}
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="text-muted small text-uppercase fw-semibold">
                        <i class="bi bi-rulers me-1"></i> Información de la talla
                    </span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.tallas.update', $talla) }}" method="POST" id="tallaForm">
                        @csrf
                        @method('PUT')

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-semibold text-dark small text-uppercase">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control rounded-3" 
                                   value="{{ old('nombre', $talla->nombre) }}" required>
                            <div class="form-text text-muted small mt-1">Ej: S, M, L, XL, 2, 4, 6, etc.</div>
                        </div>

                        {{-- Clasificación --}}
                        <div class="mb-4">
                            <label for="clasificacion_id" class="form-label fw-semibold text-dark small text-uppercase">
                                Clasificación <span class="text-danger">*</span>
                            </label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select rounded-3" required>
                                <option value="">Seleccione clasificación</option>
                                @foreach($clasificaciones as $clas)
                                    <option value="{{ $clas->id }}" {{ old('clasificacion_id', $talla->clasificacion_id) == $clas->id ? 'selected' : '' }}>
                                        {{ $clas->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted small mt-1">La clasificación determina el conjunto de tallas disponibles</div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-dark px-4">
                                <i class="bi bi-save me-2"></i> Actualizar talla
                            </button>
                            <a href="{{ route('admin.tallas.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos consistentes con el create */
.form-label {
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid #e9ecef;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #6c757d;
    box-shadow: 0 0 0 2px rgba(108, 117, 125, 0.1);
}

.btn-dark {
    background-color: #212529;
    border-color: #212529;
}

.btn-dark:hover {
    background-color: #1a1a2e;
    border-color: #1a1a2e;
}

.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.card {
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.form-text {
    font-size: 0.7rem;
}
</style>
@endsection