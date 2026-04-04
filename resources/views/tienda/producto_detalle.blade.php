@extends('layouts.app')

@section('title', $producto->nombre_comercial . ' - Branyey')

@section('content')
<div class="bg-white min-h-screen py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb small text-uppercase fw-black italic tracking-widest mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-muted text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tienda.catalogo') }}" class="text-muted text-decoration-none">Catálogo</a></li>
                <li class="breadcrumb-item active text-dark" aria-current="page">{{ $producto->nombre_comercial }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="sticky-top" style="top: 100px; z-index: 1;">
                    <div class="rounded-5 overflow-hidden shadow-sm bg-light mb-3">
                        @php $primeraImg = $producto->imagenes->first(); @endphp
                        <img id="main-product-image" 
                             src="{{ asset($primeraImg ? $primeraImg->url : 'img/placeholder.jpg') }}" 
                             class="img-fluid w-100 object-cover" 
                             style="min-height: 600px; object-position: top;">
                    </div>
                    
                    <div class="d-flex gap-2 overflow-auto pb-2" id="gallery-thumbs">
                        @foreach($producto->imagenes as $img)
                            <img src="{{ asset($img->url) }}" 
                                 class="rounded-4 thumb-img border cursor-pointer" 
                                 style="width: 85px; height: 110px; object-fit: cover;"
                                 data-full="{{ asset($img->url) }}"
                                 data-color-ref="{{ strtolower($img->color) }}"
                                 onclick="changeMainImage(this)">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ps-lg-4 pb-5">
                    <span class="badge bg-dark rounded-pill px-3 py-2 mb-3 text-uppercase tracking-widest" style="font-size: 10px;">
                        {{ $producto->clasificacion->nombre }} • {{ $tipoPrecio == 'mayorista' ? 'Precio Mayorista' : 'Colección 2026' }}
                    </span>
                    
                    <h1 class="display-3 fw-black text-uppercase italic tracking-tighter mb-2 leading-tight">
                        {{ $producto->nombre_comercial }}
                    </h1>
                    
                    <p class="text-muted fw-bold mb-4 uppercase small tracking-widest">
                        Ref: {{ $producto->estilo->nombre }}
                    </p>

                    <h2 class="fw-bold mb-5 display-5 text-dark">
                        <span id="price-display">Selecciona talla</span>
                    </h2>

                    <form action="#" method="POST" id="form-compra">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                        <div class="mb-5">
                            <label class="form-label fw-black text-uppercase small tracking-widest mb-3">1. Elige Color</label>
                            <div class="d-flex flex-wrap gap-3">
                                @php
                                    // Agrupamos los colores únicos de las variantes preparadas
                                    $colores = $producto->variantes->flatMap->colores->unique('id');
                                @endphp
                                @foreach($colores as $color)
                                    <div class="color-option">
                                        <input type="radio" name="color_id" id="c-{{ $color->id }}" value="{{ $color->id }}" 
                                               class="btn-check color-radio" 
                                               data-color-name="{{ strtolower($color->nombre) }}" required>
                                        <label class="color-circle shadow-sm" for="c-{{ $color->id }}" 
                                               style="background-color: {{ $color->codigo_hex }}; width: 45px; height: 45px; border-radius: 50%; cursor: pointer; border: 4px solid #fff; display: block;">
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-black text-uppercase small tracking-widest mb-3">2. Elige Talla</label>
                            <div class="d-flex flex-wrap gap-2" id="tallas-container">
                                @foreach($variantesPreparadas as $v)
                                    @php
                                        // Buscamos el ID del color para esta variante específica
                                        $varianteOriginal = $producto->variantes->firstWhere('id', $v['id']);
                                        $colorId = $varianteOriginal->colores->first()->id ?? 0;
                                    @endphp
                                    <div class="talla-item d-none color-group-{{ $colorId }}">
                                        <input type="radio" name="variante_id" id="v-{{ $v['id'] }}" value="{{ $v['id'] }}" 
                                               class="btn-check talla-radio" 
                                               data-precio="{{ $v['precio_formateado'] }}" 
                                               data-stock="{{ $v['stock'] }}" required>
                                        <label class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold" for="v-{{ $v['id'] }}">
                                            {{ $v['talla'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btn-add" class="btn btn-dark btn-lg rounded-pill py-3 fw-black text-uppercase tracking-widest shadow-lg" disabled>
                                Añadir al Carrito
                            </button>
                            <p id="stock-warning" class="text-danger small mt-2 d-none fw-bold text-center text-uppercase">Agotado en esta combinación</p>
                        </div>
                    </form>

                    <div class="mt-5 pt-5 border-top">
                        <h6 class="fw-black text-uppercase small tracking-widest mb-3">Descripción</h6>
                        <p class="text-muted small">{{ $producto->descripcion ?? 'Sin descripción disponible.' }}</p>
                        <ul class="list-unstyled small text-muted mt-3">
                            <li><i class="bi bi-check2-circle me-2"></i>Calidad Premium Branyey</li>
                            <li><i class="bi bi-truck me-2"></i>Envío rápido en Bogotá</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .italic { font-style: italic; }
    .tracking-tighter { letter-spacing: -3.5px; }
    .tracking-widest { letter-spacing: 2.5px; }
    .rounded-5 { border-radius: 3rem !important; }
    .cursor-pointer { cursor: pointer; }
    
    /* Efecto de selección de color */
    .color-radio:checked + .color-circle {
        border-color: #000;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    
    .btn-outline-dark { border-width: 2px; transition: 0.2s; }
    .btn-check:checked + .btn-outline-dark { background-color: #000; color: #fff; }
    
    /* Scrollbar minimalista para miniaturas */
    #gallery-thumbs::-webkit-scrollbar { height: 4px; }
    #gallery-thumbs::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
</style>

<script>
function changeMainImage(element) {
    document.getElementById('main-product-image').src = element.dataset.full;
}

document.addEventListener('DOMContentLoaded', function() {
    const colorRadios = document.querySelectorAll('.color-radio');
    const tallaRadios = document.querySelectorAll('.talla-radio');
    const priceDisplay = document.getElementById('price-display');
    const btnAdd = document.getElementById('btn-add');
    const stockWarning = document.getElementById('stock-warning');
    const mainImg = document.getElementById('main-product-image');
    const thumbs = document.querySelectorAll('.thumb-img');

    // 1. CUANDO CAMBIA EL COLOR
    colorRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const colorId = this.value;
            const colorName = this.dataset.colorName;

            // Filtrar Tallas: Ocultar todas, mostrar las del color
            document.querySelectorAll('.talla-item').forEach(el => el.classList.add('d-none'));
            document.querySelectorAll('.color-group-' + colorId).forEach(el => el.classList.remove('d-none'));

            // Cambiar Imagen Principal según el color (HU-016)
            thumbs.forEach(thumb => {
                if(thumb.dataset.colorRef === colorName) {
                    mainImg.src = thumb.dataset.full;
                }
            });

            // Reset de selecciones previas de talla
            tallaRadios.forEach(r => r.checked = false);
            priceDisplay.innerText = "Selecciona talla";
            btnAdd.disabled = true;
        });
    });

    // 2. CUANDO CAMBIA LA TALLA
    tallaRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const precio = this.dataset.precio;
            const stock = parseInt(this.dataset.stock);

            // Actualizar Precio en pantalla (HU-004)
            priceDisplay.innerText = precio;

            // Validar Stock
            if (stock > 0) {
                btnAdd.disabled = false;
                stockWarning.classList.add('d-none');
            } else {
                btnAdd.disabled = true;
                stockWarning.classList.remove('d-none');
            }
        });
    });
});
</script>
@endsection