@extends('layouts.app')

@section('title', 'Nuevo Producto - Branyey')

@section('content')
<div class="container py-4">
    @if($errors->any())
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <ul class="mb-0 small">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Nuevo Producto Branyey</h5>
                <button type="button" id="add-variant" class="btn btn-sm btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Color/Talla
                </button>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Nombre Comercial</label>
                        <input type="text" name="nombre_comercial" class="form-control" placeholder="Ej: Camisa Polo Premium" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-primary">Clasificación Global</label>
                        <select name="clasificacion_id" id="main-clasificacion" class="form-select border-primary" required>
                            <option value="">-- Seleccione Clase --</option>
                            @foreach($clasificaciones as $clas)
                                <option value="{{ $clas->id }}">{{ $clas->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estilo</label>
                        <select name="estilo_id" class="form-select" required>
                            @foreach($estilos as $estilo)
                                <option value="{{ $estilo->id }}">{{ $estilo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold text-secondary text-uppercase mb-3 small">Configuración de Variantes (Foto por color)</h6>

                <div id="variants-container">
                    <div class="variant-row border rounded-3 p-3 mb-3 bg-light shadow-sm">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="small fw-bold">1. Talla</label>
                                <select name="variantes[0][talla_id]" class="form-select select-talla" disabled required>
                                    <option value="">-- Talla --</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="small fw-bold">2. Color y Fotografía</label>
                                <select name="variantes[0][color_id]" class="form-select mb-2" required>
                                    <option value="">-- Seleccione Color --</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id }}">{{ strtoupper($color->nombre) }}</option>
                                    @endforeach
                                </select>
                                <input type="file" name="variantes[0][foto]" class="form-control form-control-sm" accept="image/*" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-success">Precio Base ($)</label>
                                <input type="number" name="variantes[0][precio_base]" class="form-control" min="0" placeholder="0" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-primary">Recargo ($)</label>
                                <input type="number" name="variantes[0][recargo_manual]" class="form-control" value="0" required>
                            </div>

                            <div class="col-md-3">
                                <label class="small fw-bold text-danger">Stock (Mín: 1)</label>
                                <div class="input-group">
                                    <input type="number" name="variantes[0][stock]" class="form-control border-danger" value="1" min="1" required>
                                    <button type="button" class="btn btn-outline-danger remove-row"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-dark btn-lg w-100 shadow-lg fw-bold">
                        <i class="bi bi-save2 me-2"></i> GUARDAR PRODUCTO COMPLETO
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const listaTallas = [@foreach($tallas as $t){id:"{{$t->id}}",nombre:"{{$t->nombre}}",clas_id:"{{$t->clasificacion_id}}"},@endforeach];
let variantIndex = 1;

function renderizarTallas(selectElement) {
    const selectedClasId = document.getElementById('main-clasificacion').value;
    selectElement.innerHTML = '<option value="">-- Talla --</option>';
    if (selectedClasId) {
        selectElement.disabled = false;
        listaTallas.filter(t => t.clas_id == selectedClasId).forEach(t => {
            selectElement.innerHTML += `<option value="${t.id}">${t.nombre}</option>`;
        });
    } else {
        selectElement.disabled = true;
    }
}

document.getElementById('main-clasificacion').addEventListener('change', function() {
    document.querySelectorAll('.select-talla').forEach(select => renderizarTallas(select));
});

document.getElementById('add-variant').addEventListener('click', function() {
    const container = document.getElementById('variants-container');
    const firstRow = document.querySelector('.variant-row');
    const newRow = firstRow.cloneNode(true);

    newRow.querySelectorAll('input').forEach(input => {
        if(input.name.includes('recargo_manual')) input.value = "0";
        else if(input.name.includes('stock')) input.value = "1";
        else input.value = "";
        input.name = input.name.replace(/\[\d+\]/, `[${variantIndex}]`);
    });

    newRow.querySelectorAll('select').forEach(select => {
        select.name = select.name.replace(/\[\d+\]/, `[${variantIndex}]`);
        if(select.classList.contains('select-talla')) renderizarTallas(select);
        else select.value = "";
    });

    container.appendChild(newRow);
    variantIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        if (document.querySelectorAll('.variant-row').length > 1) e.target.closest('.variant-row').remove();
        else alert("Debe haber al menos una variante.");
    }
});
</script>
@endsection