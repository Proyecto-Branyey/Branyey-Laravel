@extends('layouts.app')

@section('title', 'Editar Producto - Branyey')

@section('content')
<div class="container py-4">
    @if($errors->any())
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <ul class="mb-0 small">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Producto: {{ $producto->nombre_comercial }}</h5>
                <button type="button" id="add-variant" class="btn btn-sm btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Color/Talla
                </button>
            </div>

            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nombre Comercial</label>
                        <input type="text" name="nombre_comercial" class="form-control" placeholder="Ej: Camisa Polo Premium" value="{{ $producto->nombre_comercial }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción del producto">{{ $producto->descripcion }}</textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Estilo</label>
                        <select name="estilo_id" class="form-select" required>
                            @foreach($estilos as $estilo)
                                <option value="{{ $estilo->id }}" {{ $producto->estilo_id == $estilo->id ? 'selected' : '' }}>{{ $estilo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Clasificación de Talla</label>
                        <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                            <option value="">Seleccione clasificación</option>
                            @foreach($clasificaciones as $clasif)
                                <option value="{{ $clasif->id }}" {{ $producto->clasificacion_id == $clasif->id ? 'selected' : '' }}>{{ $clasif->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold text-secondary text-uppercase mb-3 small">Configuración de Variantes (Foto por color)</h6>

                <div id="variants-container">
                    @foreach($producto->variantes as $index => $variante)
                    <div class="variant-row border rounded-3 p-3 mb-3 bg-light shadow-sm">
                        <input type="hidden" name="variantes[{{ $index }}][id]" value="{{ $variante->id }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="small fw-bold">1. Talla</label>
                                <select name="variantes[{{ $index }}][talla_id]" class="form-select talla-select" required>
                                    <option value="">-- Seleccione clasificación primero --</option>
                                    @foreach($tallas->where('clasificacion_id', $producto->clasificacion_id) as $talla)
                                        <option value="{{ $talla->id }}" {{ $variante->talla_id == $talla->id ? 'selected' : '' }}>{{ $talla->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold">2. Color</label>
                                <select name="variantes[{{ $index }}][color_id]" class="form-select" required>
                                    <option value="">-- Color --</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id }}" {{ $variante->colores->first()?->id == $color->id ? 'selected' : '' }}>{{ strtoupper($color->nombre) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-success">Precio Minorista</label>
                                <input type="number" name="variantes[{{ $index }}][precio_minorista]" class="form-control" step="0.01" min="0" value="{{ $variante->precio_minorista }}" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-warning">Precio Mayorista</label>
                                <input type="number" name="variantes[{{ $index }}][precio_mayorista]" class="form-control" step="0.01" min="0" value="{{ $variante->precio_mayorista }}" required>
                            </div>

                            <div class="col-md-1">
                                <label class="small fw-bold text-info">Stock</label>
                                <input type="number" name="variantes[{{ $index }}][stock]" class="form-control" min="0" value="{{ $variante->stock }}" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold">Fotografía</label>
                                <input type="file" name="variantes[{{ $index }}][foto]" class="form-control form-control-sm" accept="image/*">
                                @php $imagenColor = $producto->imagenes->firstWhere('color_id', $variante->colores->first()?->id); @endphp
                                @if($imagenColor)
                                    <small class="text-muted">Imagen actual: <a href="{{ Storage::url($imagenColor->url) }}" target="_blank">Ver</a></small>
                                @endif
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger remove-row w-100"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-dark btn-lg w-100 shadow-lg fw-bold">
                        <i class="bi bi-save2 me-2"></i> ACTUALIZAR PRODUCTO
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let variantIndex = {{ count($producto->variantes) }};

// Datos de tallas por clasificación
const tallasPorClasificacion = {
    @foreach($clasificaciones as $clasif)
        {{ $clasif->id }}: [
            @foreach($tallas->where('clasificacion_id', $clasif->id) as $talla)
                {id: {{ $talla->id }}, nombre: '{{ $talla->nombre }}'},
            @endforeach
        ],
    @endforeach
};

// Función para actualizar todos los selects de tallas
function updateTallaSelects(clasificacionId) {
    const selects = document.querySelectorAll('.talla-select');

    selects.forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">-- Talla --</option>';

        if (clasificacionId && tallasPorClasificacion[clasificacionId]) {
            tallasPorClasificacion[clasificacionId].forEach(talla => {
                const option = document.createElement('option');
                option.value = talla.id;
                option.textContent = talla.nombre;
                if (currentValue == talla.id) option.selected = true;
                select.appendChild(option);
            });
        }
    });
}

// Event listener para cambio de clasificación
document.getElementById('clasificacion_id').addEventListener('change', function() {
    const clasificacionId = this.value;
    updateTallaSelects(clasificacionId);
});

document.getElementById('add-variant').addEventListener('click', function() {
    const container = document.getElementById('variants-container');
    const firstRow = document.querySelector('.variant-row');

    // Crear nueva fila basada en la primera
    const newRow = firstRow.cloneNode(true);

    // Limpiar valores de inputs
    newRow.querySelectorAll('input[type="hidden"]').forEach(input => input.remove()); // Remover ID de variante existente
    newRow.querySelectorAll('input, select').forEach(input => {
        if(input.type === 'file') {
            input.value = '';
        } else if(input.type === 'number') {
            input.value = '';
        } else if(input.classList.contains('talla-select')) {
            input.value = '';
        } else {
            input.value = '';
        }
        input.name = input.name.replace(/\[\d+\]/, `[${variantIndex}]`);
    });

    // Limpiar texto de imagen actual
    const smallText = newRow.querySelector('small');
    if (smallText) smallText.remove();

    container.appendChild(newRow);

    // Actualizar tallas en la nueva fila
    const clasificacionId = document.getElementById('clasificacion_id').value;
    updateTallaSelects(clasificacionId);

    variantIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        if (document.querySelectorAll('.variant-row').length > 1) {
            e.target.closest('.variant-row').remove();
        } else {
            alert("Debe haber al menos una variante.");
        }
    }
});

// Inicializar tallas al cargar
document.addEventListener('DOMContentLoaded', function() {
    const clasificacionId = document.getElementById('clasificacion_id').value;
    if (clasificacionId) {
        updateTallaSelects(clasificacionId);
    }
});
</script>
@endsection