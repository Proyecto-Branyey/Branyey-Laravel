@extends('layouts.admin')

@section('title', 'Nueva Talla - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-plus-circle me-2 text-secondary"></i>Nueva Talla
            </h1>
            <p class="text-muted small mb-0">Registra una nueva talla en el catálogo</p>
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
                        <i class="bi bi-rulers me-1"></i> Datos de la talla
                    </span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.tallas.store') }}" method="POST" id="tallaForm">
                        @csrf

                        {{-- Clasificación --}}
                        <div class="mb-4">
                            <label for="clasificacion_id" class="form-label fw-semibold text-dark small text-uppercase">
                                Clasificación <span class="text-danger">*</span>
                            </label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select rounded-3" required>
                                <option value="">Seleccione clasificación</option>
                                @foreach($clasificaciones as $clas)
                                    <option value="{{ $clas->id }}">{{ $clas->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted small mt-1">La clasificación determina el conjunto de tallas disponibles</div>
                        </div>

                        {{-- Talla existente --}}
                        <div class="mb-4" id="tallas-container" style="display: none;">
                            <label for="talla_select" class="form-label fw-semibold text-dark small text-uppercase">
                                Talla existente
                            </label>
                            <select id="talla_select" class="form-select rounded-3">
                                <option value="">Seleccione talla existente</option>
                            </select>
                            <div class="form-text text-muted small mt-1">Puedes seleccionar una talla de la lista predefinida</div>
                        </div>

                        {{-- Nueva talla --}}
                        <div class="mb-4" id="nueva-talla-container" style="display: none;">
                            <label for="nombre" class="form-label fw-semibold text-dark small text-uppercase">
                                Nueva talla
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control rounded-3" placeholder="Ej: XXL, 18, Extra Large">
                            <div class="form-text text-muted small mt-1">Deja vacío si seleccionaste una talla existente</div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-dark px-4" id="submit-btn" disabled>
                                <i class="bi bi-save me-2"></i> Guardar talla
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
/* Estilos consistentes */
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const clasificacionSelect = document.getElementById('clasificacion_id');
    const tallasContainer = document.getElementById('tallas-container');
    const nuevaTallaContainer = document.getElementById('nueva-talla-container');
    const tallaSelect = document.getElementById('talla_select');
    const nombreInput = document.getElementById('nombre');
    const submitBtn = document.getElementById('submit-btn');

    // Tallas por clasificación (de acuerdo al seeder)
    const tallasPorClasificacion = {
        1: ['2', '4', '6', '8', '10', '12', '14', '16'], // Niño
        2: ['S', 'M', 'L', 'XL'], // Dama
        3: ['S', 'M', 'L', 'XL', 'XXL'] // Adulto
    };

    clasificacionSelect.addEventListener('change', function() {
        const clasificacionId = this.value;
        
        if (clasificacionId) {
            // Mostrar contenedores
            tallasContainer.style.display = 'block';
            nuevaTallaContainer.style.display = 'block';
            
            // Limpiar y poblar el select de tallas
            tallaSelect.innerHTML = '<option value="">Seleccione talla existente</option>';
            
            if (tallasPorClasificacion[clasificacionId]) {
                tallasPorClasificacion[clasificacionId].forEach(talla => {
                    const option = document.createElement('option');
                    option.value = talla;
                    option.textContent = talla;
                    tallaSelect.appendChild(option);
                });
            }
            
            // Habilitar submit
            submitBtn.disabled = false;
        } else {
            // Ocultar contenedores si no hay selección
            tallasContainer.style.display = 'none';
            nuevaTallaContainer.style.display = 'none';
            submitBtn.disabled = true;
        }
        
        // Limpiar campos
        tallaSelect.value = '';
        nombreInput.value = '';
    });

    // Cuando se selecciona una talla existente, limpiar el campo de nueva talla
    tallaSelect.addEventListener('change', function() {
        if (this.value) {
            nombreInput.value = '';
        }
    });

    // Cuando se escribe en nueva talla, deseleccionar la talla existente
    nombreInput.addEventListener('input', function() {
        if (this.value.trim()) {
            tallaSelect.value = '';
        }
    });

    // Validación antes de enviar
    document.getElementById('tallaForm').addEventListener('submit', function(e) {
        const clasificacionId = clasificacionSelect.value;
        const tallaSeleccionada = tallaSelect.value;
        const nuevaTalla = nombreInput.value.trim();
        
        if (!clasificacionId) {
            e.preventDefault();
            alert('Por favor selecciona una clasificación');
            return;
        }
        
        if (!tallaSeleccionada && !nuevaTalla) {
            e.preventDefault();
            alert('Por favor selecciona una talla existente o ingresa una nueva');
            return;
        }
        
        // Si se seleccionó una talla existente, usar esa como nombre
        if (tallaSeleccionada && !nuevaTalla) {
            nombreInput.value = tallaSeleccionada;
        }
    });
});
</script>
@endsection