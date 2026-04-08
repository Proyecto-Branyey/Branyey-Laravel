@extends('layouts.admin')

@section('title', 'Editar Producto - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-pencil-square me-2"></i>Editar Producto
            </h1>
            <p class="text-muted small mb-0">Modifica la información del producto #{{ $producto->id }}</p>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <div class="form-card">
        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PUT')

            {{-- Sección 1: Información básica --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-info-circle"></i>
                    <h5>Información básica</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-tag me-1"></i>Nombre comercial <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre_comercial" class="form-input" 
                                   value="{{ old('nombre_comercial', $producto->nombre_comercial) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-brush me-1"></i>Estilo <span class="text-danger">*</span>
                            </label>
                            <select name="estilo_id" class="form-select" required>
                                <option value="">Seleccione un estilo</option>
                                @foreach($estilos as $estilo)
                                    <option value="{{ $estilo->id }}" {{ old('estilo_id', $producto->estilo_id) == $estilo->id ? 'selected' : '' }}>
                                        {{ $estilo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-person-standing me-1"></i>Clasificación <span class="text-danger">*</span>
                            </label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                                <option value="">Seleccione clasificación</option>
                                @foreach($clasificaciones as $clasif)
                                    <option value="{{ $clasif->id }}" {{ old('clasificacion_id', $producto->clasificacion_id) == $clasif->id ? 'selected' : '' }}>
                                        {{ $clasif->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-file-text me-1"></i>Descripción
                            </label>
                            <textarea name="descripcion" class="form-input" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 2: Variantes --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-layers"></i>
                    <h5>Variantes del producto</h5>
                </div>
                
                <div class="variants-header">
                    <button type="button" id="add-variant" class="btn-add-variant">
                        <i class="bi bi-plus-circle me-2"></i>Agregar variante
                    </button>
                    <p class="text-muted small mb-0">Cada variante combina talla y color. La foto se asigna por color.</p>
                </div>

                <div id="variants-container">
                    @foreach($producto->variantes as $index => $variante)
                    <div class="variant-card" data-variant-id="{{ $variante->id }}">
                        <div class="variant-header">
                            <span class="variant-number">Variante #{{ $index + 1 }}</span>
                            <button type="button" class="btn-remove-variant" {{ $loop->first ? 'disabled style="opacity: 0.5;"' : '' }}>
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        <input type="hidden" name="variantes[{{ $index }}][id]" value="{{ $variante->id }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="variant-label">Talla</label>
                                <select name="variantes[{{ $index }}][talla_id]" class="form-input talla-select" required>
                                    <option value="">-- Seleccione talla --</option>
                                    @foreach($tallas->where('clasificacion_id', $producto->clasificacion_id) as $talla)
                                        <option value="{{ $talla->id }}" {{ $variante->talla_id == $talla->id ? 'selected' : '' }}>
                                            {{ $talla->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="variant-label">Color</label>
                                <select name="variantes[{{ $index }}][color_id]" class="form-input color-select" required>
                                    <option value="">-- Seleccione color --</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id }}" {{ $variante->colores->first()?->id == $color->id ? 'selected' : '' }}>
                                            {{ ucfirst($color->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="variant-label text-success">Precio minorista</label>
                                <input type="number" name="variantes[{{ $index }}][precio_minorista]" class="form-input" 
                                       step="0.01" min="0" value="{{ $variante->precio_minorista }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="variant-label text-warning">Precio mayorista</label>
                                <input type="number" name="variantes[{{ $index }}][precio_mayorista]" class="form-input" 
                                       step="0.01" min="0" value="{{ $variante->precio_mayorista }}" required>
                            </div>
                            <div class="col-md-1">
                                <label class="variant-label text-info">Stock</label>
                                <input type="number" name="variantes[{{ $index }}][stock]" class="form-input" 
                                       min="0" value="{{ $variante->stock }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="variant-label">Fotografía</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="variantes[{{ $index }}][foto]" class="form-input foto-input" accept="image/*">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <small class="form-hint foto-help d-none">Color repetido: se reutilizará la imagen</small>
                                @php 
                                    $colorId = $variante->colores->first()?->id;
                                    $imagenColor = $imagenesPorColor[$colorId] ?? null;
                                @endphp
                                @if($imagenColor)
                                    <div class="foto-preview mt-2">
                                        <small class="text-muted">Imagen actual:</small>
                                        <a href="{{ Storage::url($imagenColor->url) }}" target="_blank" class="foto-link">Ver imagen</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Alerta de cambios pendientes --}}
                <div id="pending-changes-alert" class="pending-alert d-none">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Tienes cambios pendientes. Para guardarlos debes presionar <strong>Actualizar producto</strong>.
                </div>
            </div>

            {{-- Botones --}}
            <div class="form-actions">
                <button type="submit" class="btn-save" id="submitBtn">
                    <i class="bi bi-save2 me-2"></i>Actualizar producto
                </button>
                <a href="{{ route('admin.productos.index') }}" class="btn-cancel">
                    <i class="bi bi-x-lg me-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* ===== FORM CARD ===== */
.form-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
}

.section-header i {
    font-size: 1.2rem;
    color: #667eea;
}

.section-header h5 {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin: 0;
}

/* ===== FORM GROUPS ===== */
.form-group {
    margin-bottom: 0.25rem;
}

.form-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.form-input, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-input {
    resize: vertical;
}

/* ===== VARIANTES ===== */
.variants-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.btn-add-variant {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-add-variant:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
}

.variant-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.variant-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
}

.variant-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px dashed #dee2e6;
}

.variant-number {
    font-size: 0.75rem;
    font-weight: 700;
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    padding: 4px 12px;
    border-radius: 20px;
}

.btn-remove-variant {
    background: transparent;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-remove-variant:hover:not(:disabled) {
    background: rgba(220, 53, 69, 0.1);
    transform: scale(1.05);
}

.btn-remove-variant:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.variant-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    margin-bottom: 0.4rem;
}

/* ===== FILE INPUT ===== */
.file-input-wrapper {
    position: relative;
}

.file-input-wrapper input[type="file"] {
    padding: 0.75rem 1rem;
    padding-left: 2.5rem;
    cursor: pointer;
}

.file-input-wrapper i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
    pointer-events: none;
}

.foto-preview {
    margin-top: 0.5rem;
}

.foto-link {
    font-size: 0.7rem;
    color: #667eea;
    text-decoration: none;
}

.foto-link:hover {
    text-decoration: underline;
}

.form-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== ALERTAS ===== */
.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    border-left: 3px solid #dc3545;
}

.alert-error-card ul {
    padding-left: 1.5rem;
    margin: 0;
}

.pending-alert {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.8rem;
    font-weight: 500;
    border-left: 3px solid #ffc107;
    margin-top: 1rem;
}

/* ===== BOTONES ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.75rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-save:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea, #764ba2);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

.btn-action-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-outline:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-card {
        padding: 1.5rem;
    }
    
    .variants-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .btn-add-variant {
        width: 100%;
        justify-content: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-save, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
let variantIndex = {{ count($producto->variantes) }};
let hasPendingChanges = false;
const form = document.getElementById('productForm');
const pendingChangesAlert = document.getElementById('pending-changes-alert');

function markPendingChanges() {
    hasPendingChanges = true;
    if (pendingChangesAlert) pendingChangesAlert.classList.remove('d-none');
}

function clearPendingChanges() {
    hasPendingChanges = false;
    if (pendingChangesAlert) pendingChangesAlert.classList.add('d-none');
}

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

const imagenesPorColor = {
    @foreach($imagenesPorColor as $colorId => $img)
        {{ $colorId }}: '{{ Storage::url($img->url) }}',
    @endforeach
};

// Función para actualizar todos los selects de tallas
function updateTallaSelects(clasificacionId) {
    const selects = document.querySelectorAll('.talla-select');
    selects.forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">-- Seleccione talla --</option>';
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

function renderPreview(row, colorId, localFileUrl = null) {
    const preview = row.querySelector('.foto-preview');
    if (!preview) return;
    if (localFileUrl) {
        preview.innerHTML = `<small class="text-success d-block">Nueva imagen seleccionada</small>
                             <img src="${localFileUrl}" alt="preview" class="img-thumbnail mt-1" style="max-height: 64px;">`;
        return;
    }
    if (colorId && imagenesPorColor[colorId]) {
        const url = imagenesPorColor[colorId];
        preview.innerHTML = `<small class="text-muted">Imagen actual:</small>
                             <a href="${url}" target="_blank" class="foto-link">Ver imagen</a>`;
        return;
    }
    preview.innerHTML = '';
}

function syncFotoInputsByColor() {
    const rows = document.querySelectorAll('.variant-card');
    const firstColorRow = {};
    rows.forEach(row => {
        const colorSelect = row.querySelector('.color-select');
        const fotoInput = row.querySelector('.foto-input');
        const fotoHelp = row.querySelector('.foto-help');
        if (!colorSelect || !fotoInput) return;
        const colorId = colorSelect.value;
        const isDuplicateColor = colorId && firstColorRow[colorId];
        if (isDuplicateColor) {
            fotoInput.value = '';
            fotoInput.required = false;
            fotoInput.disabled = true;
            if (fotoHelp) fotoHelp.classList.remove('d-none');
            renderPreview(row, colorId);
        } else {
            fotoInput.disabled = false;
            fotoInput.required = false;
            if (fotoHelp) fotoHelp.classList.add('d-none');
            if (colorId) firstColorRow[colorId] = true;
            renderPreview(row, colorId);
        }
    });
}

// Event listener para cambio de clasificación
document.getElementById('clasificacion_id').addEventListener('change', function() {
    updateTallaSelects(this.value);
    markPendingChanges();
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('color-select')) {
        const row = e.target.closest('.variant-card');
        if (row) {
            const fotoInput = row.querySelector('.foto-input');
            if (fotoInput) fotoInput.value = '';
            renderPreview(row, e.target.value);
        }
        syncFotoInputsByColor();
        markPendingChanges();
    }
    if (e.target.classList.contains('foto-input')) {
        const row = e.target.closest('.variant-card');
        if (row && e.target.files && e.target.files[0]) {
            const tmpUrl = URL.createObjectURL(e.target.files[0]);
            renderPreview(row, null, tmpUrl);
        }
        markPendingChanges();
    }
});

document.getElementById('add-variant').addEventListener('click', function() {
    const container = document.getElementById('variants-container');
    const firstRow = document.querySelector('.variant-card');
    if (!firstRow) return;
    const newRow = firstRow.cloneNode(true);
    const variantNumber = variantIndex + 1;
    // Actualizar número de variante
    const variantHeader = newRow.querySelector('.variant-number');
    if (variantHeader) variantHeader.textContent = `Variante #${variantNumber}`;
    // Habilitar botón de eliminar
    const removeBtn = newRow.querySelector('.btn-remove-variant');
    if (removeBtn) {
        removeBtn.disabled = false;
        removeBtn.style.opacity = '1';
    }
    // Limpiar valores
    newRow.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
    newRow.querySelectorAll('input, select').forEach(input => {
        if (input.type === 'file') input.value = '';
        else if (input.type === 'number') input.value = '';
        else if (input.classList.contains('talla-select')) input.value = '';
        else input.value = '';
        const match = input.name.match(/\[\d+\]/);
        if (match) input.name = input.name.replace(/\[\d+\]/, `[${variantIndex}]`);
    });
    const preview = newRow.querySelector('.foto-preview');
    if (preview) preview.innerHTML = '';
    const fotoHelp = newRow.querySelector('.foto-help');
    if (fotoHelp) fotoHelp.classList.add('d-none');
    container.appendChild(newRow);
    const clasificacionId = document.getElementById('clasificacion_id').value;
    updateTallaSelects(clasificacionId);
    syncFotoInputsByColor();
    variantIndex++;
    markPendingChanges();
});

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-remove-variant');
    if (btn && !btn.disabled) {
        const rows = document.querySelectorAll('.variant-card');
        if (rows.length > 1) {
            btn.closest('.variant-card').remove();
            document.querySelectorAll('.variant-card').forEach((card, idx) => {
                const numberSpan = card.querySelector('.variant-number');
                if (numberSpan) numberSpan.textContent = `Variante #${idx + 1}`;
            });
            syncFotoInputsByColor();
            markPendingChanges();
        } else {
            alert("Debe haber al menos una variante.");
        }
    }
});

document.addEventListener('input', function(e) {
    if (e.target.closest('#productForm')) markPendingChanges();
});

if (form) {
    form.addEventListener('submit', () => clearPendingChanges());
}

window.addEventListener('beforeunload', function(e) {
    if (hasPendingChanges) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    const clasificacionId = document.getElementById('clasificacion_id').value;
    if (clasificacionId) updateTallaSelects(clasificacionId);
    syncFotoInputsByColor();
});
</script>
@endsection