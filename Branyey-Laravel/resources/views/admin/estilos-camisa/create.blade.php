@extends('layouts.admin')

@section('title', 'Nuevo Estilo - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-plus-circle me-2 text-secondary"></i>Nuevo Estilo
            </h1>
            <p class="text-muted small mb-0">Registra un nuevo estilo de camisa en el catálogo</p>
        </div>
        <a href="{{ route('admin.estilos-camisa.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Formulario --}}
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="text-muted small text-uppercase fw-semibold">
                        <i class="bi bi-brush me-1"></i> Datos del estilo
                    </span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.estilos-camisa.store') }}" method="POST" id="estiloForm">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-semibold text-dark small text-uppercase">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control rounded-3" 
                                   placeholder="Ej: Clásico, Moderno, Deportivo, Formal" required>
                            <div class="form-text text-muted small mt-1">Nombre descriptivo del estilo de camisa</div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-dark px-4">
                                <i class="bi bi-save me-2"></i> Guardar estilo
                            </button>
                            <a href="{{ route('admin.estilos-camisa.index') }}" class="btn btn-outline-secondary px-4">
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
/* Estilos consistentes */
.form-label {
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #e9ecef;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}

.form-control:focus {
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nombreInput = document.getElementById('nombre');
    
    // Capitalizar primera letra al enviar (opcional)
    document.getElementById('estiloForm').addEventListener('submit', function(e) {
        if (nombreInput.value) {
            nombreInput.value = nombreInput.value.trim();
        }
    });
});
</script>
@endsection