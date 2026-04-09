@extends('layouts.admin')

@section('title', 'Nuevo Color - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="bi bi-plus-circle me-2 text-secondary"></i>Nuevo Color
            </h1>
            <p class="text-muted small mb-0">Registra un nuevo color en el catálogo</p>
        </div>
        <a href="{{ route('admin.colores.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Formulario --}}
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="text-muted small text-uppercase fw-semibold">
                        <i class="bi bi-palette me-1"></i> Datos del color
                    </span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.colores.store') }}" method="POST" id="colorForm">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-semibold text-dark small text-uppercase">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control rounded-3" 
                                   placeholder="Ej: Rojo, Azul, Negro, Blanco" required>
                            <div class="form-text text-muted small mt-1">Nombre descriptivo del color</div>
                        </div>

                        {{-- Código Hex con preview --}}
                        <div class="mb-4">
                            <label for="codigo_hex" class="form-label fw-semibold text-dark small text-uppercase">
                                Código Hex
                            </label>
                            <div class="row g-3 align-items-end">
                                <div class="col-8">
                                    <input type="text" name="codigo_hex" id="codigo_hex" class="form-control rounded-3" 
                                           placeholder="#000000" value="#000000" maxlength="7">
                                    <div class="form-text text-muted small mt-1">Formato hexadecimal (ej: #FF5733)</div>
                                </div>
                                <div class="col-4">
                                    <div class="color-preview-wrapper">
                                        <div id="colorPreview" class="color-preview" style="background-color: #000000;"></div>
                                        <input type="color" id="colorPicker" class="color-picker" value="#000000">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-dark px-4">
                                <i class="bi bi-save me-2"></i> Guardar color
                            </button>
                            <a href="{{ route('admin.colores.index') }}" class="btn btn-outline-secondary px-4">
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

/* Preview de color */
.color-preview-wrapper {
    display: flex;
    gap: 8px;
    align-items: center;
}

.color-preview {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    border: 1px solid #dee2e6;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: background-color 0.2s ease;
}

.color-picker {
    width: 48px;
    height: 48px;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    cursor: pointer;
    padding: 4px;
    background: white;
}

.color-picker::-webkit-color-swatch-wrapper {
    padding: 0;
}

.color-picker::-webkit-color-swatch {
    border: none;
    border-radius: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoHexInput = document.getElementById('codigo_hex');
    const colorPicker = document.getElementById('colorPicker');
    const colorPreview = document.getElementById('colorPreview');
    
    // Sincronizar el input de texto con el color picker
    colorPicker.addEventListener('input', function() {
        const color = this.value;
        codigoHexInput.value = color.toUpperCase();
        colorPreview.style.backgroundColor = color;
    });
    
    // Sincronizar el color picker con el input de texto
    codigoHexInput.addEventListener('input', function() {
        let value = this.value.trim();
        if (value && /^#[0-9A-Fa-f]{6}$/.test(value)) {
            colorPicker.value = value;
            colorPreview.style.backgroundColor = value;
        }
    });
    
    // Formatear el código hex al perder el foco
    codigoHexInput.addEventListener('blur', function() {
        let value = this.value.trim();
        if (value && !value.startsWith('#')) {
            value = '#' + value;
        }
        if (value && /^#[0-9A-Fa-f]{6}$/i.test(value)) {
            this.value = value.toUpperCase();
            colorPicker.value = value.toUpperCase();
            colorPreview.style.backgroundColor = value.toUpperCase();
        } else if (value && value.length > 0) {
            // Si no es válido, restaurar el último valor válido
            this.value = colorPicker.value;
        }
    });
});
</script>
@endsection