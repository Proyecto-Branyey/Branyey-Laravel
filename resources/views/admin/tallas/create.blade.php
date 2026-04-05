@extends('layouts.app')

@section('title', 'Nueva Talla - Branyey')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Nueva Talla</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tallas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="clasificacion_id" class="form-label">Clasificación</label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                                <option value="">Seleccione clasificación</option>
                                @foreach($clasificaciones as $clas)
                                    <option value="{{ $clas->id }}">{{ $clas->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="tallas-container" style="display: none;">
                            <label for="talla_select" class="form-label">Talla existente</label>
                            <select id="talla_select" class="form-select">
                                <option value="">Seleccione talla</option>
                            </select>
                            <div class="form-text">O ingrese una nueva talla abajo</div>
                        </div>
                        <div class="mb-3" id="nueva-talla-container" style="display: none;">
                            <label for="nombre" class="form-label">Nueva Talla</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: XXL, 18, etc.">
                            <div class="form-text">Deja vacío si seleccionas una talla existente arriba</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Guardar</button>
                            <a href="{{ route('admin.tallas.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
        3: ['s', 'm', 'l', 'xl', 'xxl'] // Adulto
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
    document.querySelector('form').addEventListener('submit', function(e) {
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