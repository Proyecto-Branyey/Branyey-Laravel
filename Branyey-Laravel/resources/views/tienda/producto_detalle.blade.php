@extends('layouts.app')

@section('title', $producto->nombre_comercial . ' - Branyey')

@section('content')
<div class="bg-white py-5">
    <div class="container">
        {{-- Botón Volver --}}
        <div class="mb-4">
            <a href="{{ route('tienda.catalogo') }}" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>
                Volver al catálogo
            </a>
        </div>

        <div class="row g-5">
            {{-- Galería de Imágenes --}}
            <div class="col-lg-7">
                <div class="product-gallery">
                    @php $primeraImg = $producto->imagenes->first(); @endphp
                    <div class="main-image-container">
                        <img id="main-product-image" 
                             src="{{ $primeraImg ? Storage::url($primeraImg->url) : asset('img/placeholder.jpg') }}"
                             alt="{{ $producto->nombre_comercial }}"
                             class="main-product-image">
                    </div>

                    @if($producto->variantes->flatMap->colores->unique('id')->count() > 1)
                        <div class="thumbnail-gallery">
                            @foreach($producto->variantes->flatMap->colores->unique('id') as $color)
                                @php
                                    $imagenColor = $producto->imagenes->firstWhere('color_id', $color->id);
                                @endphp
                                @if($imagenColor)
                                    <div class="thumbnail-item {{ $loop->first ? 'active' : '' }}"
                                         onclick="changeMainImage(this, '{{ Storage::url($imagenColor->url) }}', {{ $color->id }})">
                                        <img src="{{ Storage::url($imagenColor->url) }}" 
                                             alt="{{ $color->nombre }}"
                                             data-full="{{ Storage::url($imagenColor->url) }}"
                                             data-color-id="{{ $color->id }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Información del Producto --}}
            <div class="col-lg-5">
                <div class="product-info">
                    <div class="product-header">
                        <span class="product-category-badge">
                            {{ $producto->estilo?->nombre ?? 'Premium' }}
                        </span>
                        <h1 class="product-title">{{ $producto->nombre_comercial }}</h1>
                        <p class="product-reference">REF: {{ $producto->estilo?->nombre ?? '' }}-{{ $producto->id }}</p>
                        
                        @if($producto->descripcion)
                            <div class="product-description mt-3">
                                <h5 class="description-title">
                                    <i class="bi bi-info-circle me-2"></i>Descripción
                                </h5>
                                <p class="description-text">{{ $producto->descripcion }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="product-price-section">
                        <div class="price-container">
                            <span id="price-display" class="product-price-display">
                                Selecciona color y talla
                            </span>
                        </div>
                        <div class="stock-info">
                            <i class="bi bi-box-seam me-2"></i>
                            Stock disponible: <span id="stock-actual" class="fw-bold">0</span> unidades
                        </div>
                    </div>

                    <form action="{{ route('tienda.cart.add') }}" method="POST" id="form-compra">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                        <div class="selection-group">
                            <label class="selection-label">
                                <i class="bi bi-palette me-2"></i>1. Elige Color
                            </label>
                            <div class="color-options">
                                @foreach($producto->variantes->flatMap->colores->unique('id') as $color)
                                    <div class="color-option-wrapper">
                                        <input type="radio" name="color_id" id="color-{{ $color->id }}" 
                                               value="{{ $color->id }}" 
                                               class="color-input"
                                               data-color-id="{{ $color->id }}"
                                               data-color-name="{{ $color->nombre }}">
                                        <label for="color-{{ $color->id }}" 
                                               class="color-label"
                                               style="background-color: {{ $color->codigo_hex ?? '#000000' }};"
                                               title="{{ $color->nombre }}">
                                            <span class="color-tooltip">{{ $color->nombre }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="selection-group">
                            <label class="selection-label">
                                <i class="bi bi-rulers me-2"></i>2. Elige Talla
                            </label>
                            <div class="size-options" id="tallas-container">
                                @foreach($producto->variantes as $v)
                                    @foreach($v->colores as $color)
                                        <div class="size-option-wrapper d-none color-group-{{ $color->id }}">
                                            <input type="radio" name="variante_id" id="size-{{ $v->id }}" 
                                                   value="{{ $v->id }}" 
                                                   class="size-input"
                                                   data-precio="${{ number_format($v->getPrecioActual(), 0, ',', '.') }} COP"
                                                   data-stock="{{ $v->stock }}">
                                            <label for="size-{{ $v->id }}" class="size-label">
                                                {{ $v->talla?->nombre ?? 'Única' }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <div class="purchase-section">
                            <div class="quantity-control">
                                <label class="selection-label">3. Cantidad</label>
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn" onclick="updateQuantity(-1)">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                    <input type="number" name="quantity" id="input-quantity" 
                                           value="1" min="1" max="99" 
                                           class="quantity-input">
                                    <button type="button" class="quantity-btn" onclick="updateQuantity(1)">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" id="btn-add" class="btn-add-to-cart" disabled>
                                <i class="bi bi-bag-plus me-2"></i>
                                Añadir al Carrito
                            </button>
                            
                            <div id="stock-warning" class="stock-warning d-none">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Agotado en esta combinación
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const cantidadesCarrito = @json(session('cart', []));

function changeMainImage(element, imageUrl, colorId) {
    document.getElementById('main-product-image').src = imageUrl;
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
}

function updateQuantity(change) {
    const input = document.getElementById('input-quantity');
    let newValue = parseInt(input.value) + change;
    const max = parseInt(input.max) || 99;
    const min = parseInt(input.min) || 1;
    
    if (newValue >= min && newValue <= max) {
        input.value = newValue;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const colorInputs = document.querySelectorAll('.color-input');
    const sizeInputs = document.querySelectorAll('.size-input');
    const btnAdd = document.getElementById('btn-add');
    const priceDisplay = document.getElementById('price-display');
    const inputQuantity = document.getElementById('input-quantity');
    const stockActual = document.getElementById('stock-actual');
    const stockWarning = document.getElementById('stock-warning');
    
    let currentVarianteId = null;

    colorInputs.forEach(input => {
        input.addEventListener('change', function() {
            const colorId = this.dataset.colorId;
            
            document.querySelectorAll('.size-option-wrapper').forEach(el => {
                el.classList.add('d-none');
            });
            
            document.querySelectorAll('.color-group-' + colorId).forEach(el => {
                el.classList.remove('d-none');
            });
            
            sizeInputs.forEach(r => r.checked = false);
            btnAdd.disabled = true;
            priceDisplay.innerHTML = 'Ahora elige una talla';
            stockWarning.classList.add('d-none');
            currentVarianteId = null;
            
            const colorThumb = document.querySelector(`.thumbnail-item[data-color-id="${colorId}"]`);
            if(colorThumb) {
                const thumbImg = colorThumb.querySelector('img');
                if(thumbImg && thumbImg.dataset.full) {
                    document.getElementById('main-product-image').src = thumbImg.dataset.full;
                }
            }
        });
    });

    sizeInputs.forEach(input => {
        input.addEventListener('change', function() {
            const stock = parseInt(this.dataset.stock);
            const precio = this.dataset.precio;
            currentVarianteId = this.value;
            
            priceDisplay.innerHTML = precio;
            
            let cantidadEnCarrito = 0;
            if (cantidadesCarrito[currentVarianteId] && cantidadesCarrito[currentVarianteId]['quantity']) {
                cantidadEnCarrito = parseInt(cantidadesCarrito[currentVarianteId]['quantity']);
            }
            const stockDisponible = Math.max(stock - cantidadEnCarrito, 0);
            
            inputQuantity.max = stockDisponible;
            inputQuantity.value = stockDisponible > 0 ? 1 : 0;
            stockActual.textContent = stockDisponible;
            
            if (stockDisponible > 0) {
                btnAdd.disabled = false;
                stockWarning.classList.add('d-none');
            } else {
                btnAdd.disabled = true;
                stockWarning.classList.remove('d-none');
            }
        });
    });
    
    document.getElementById('form-compra').addEventListener('submit', function(e) {
        const quantity = parseInt(inputQuantity.value);
        const maxStock = parseInt(inputQuantity.max);
        
        if (quantity > maxStock) {
            e.preventDefault();
            stockWarning.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>Solo hay ' + maxStock + ' unidades disponibles';
            stockWarning.classList.remove('d-none');
        }
    });
});
</script>

<style>
/* ===== BOTÓN VOLVER ===== */
.btn-back {
    display: inline-flex;
    align-items: center;
    background: transparent;
    border: none;
    color: #6c757d;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    padding: 0.5rem 0;
    transition: all 0.3s ease;
}

.btn-back:hover {
    color: #667eea;
    transform: translateX(-4px);
}

/* ===== PRODUCT GALLERY ===== */
.product-gallery {
    position: relative;
}

.main-image-container {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
    margin-bottom: 1rem;
}

.main-product-image {
    width: 100%;
    height: auto;
    min-height: 500px;
    max-height: 600px;
    object-fit: cover;
    object-position: top;
    transition: transform 0.5s ease;
}

.main-image-container:hover .main-product-image {
    transform: scale(1.02);
}

.thumbnail-gallery {
    display: flex;
    gap: 0.75rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
}

.thumbnail-gallery::-webkit-scrollbar {
    height: 4px;
}

.thumbnail-gallery::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.thumbnail-gallery::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 10px;
}

.thumbnail-item {
    flex-shrink: 0;
    width: 80px;
    height: 100px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-item:hover {
    transform: translateY(-2px);
}

.thumbnail-item.active {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* ===== PRODUCT INFO ===== */
.product-info {
    position: sticky;
    top: 90px;
}

.product-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.product-category-badge {
    display: inline-block;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 12px;
    border-radius: 30px;
    margin-bottom: 0.75rem;
}

.product-title {
    font-size: 2rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
    letter-spacing: -1px;
}

.product-reference {
    font-size: 0.75rem;
    color: #6c757d;
    letter-spacing: 1px;
}

/* ===== PRICE SECTION ===== */
.product-price-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #f0f2f5 100%);
    padding: 1.25rem;
    border-radius: 16px;
    margin-bottom: 1.5rem;
}

.product-price-display {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1a1a2e;
    display: block;
    margin-bottom: 0.5rem;
}

.stock-info {
    font-size: 0.8rem;
    color: #6c757d;
    padding-top: 0.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

/* ===== SELECTION GROUPS ===== */
.selection-group {
    margin-bottom: 1.75rem;
}

.selection-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.75rem;
}

.color-options {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.color-option-wrapper {
    position: relative;
}

.color-input {
    display: none;
}

.color-label {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: block;
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
}

.color-label:hover {
    transform: scale(1.1);
}

.color-input:checked + .color-label {
    border-color: #667eea;
    transform: scale(1.1);
    box-shadow: 0 0 0 2px #667eea;
}

.color-tooltip {
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: #1a1a2e;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.65rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    pointer-events: none;
}

.color-label:hover .color-tooltip {
    opacity: 1;
    visibility: visible;
    bottom: -25px;
}

.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.size-option-wrapper {
    margin: 0;
}

.size-input {
    display: none;
}

.size-label {
    display: inline-block;
    padding: 0.5rem 1.25rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-label:hover {
    background: #e9ecef;
    transform: translateY(-1px);
}

.size-input:checked + .size-label {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* ===== PURCHASE SECTION ===== */
.purchase-section {
    margin-top: 2rem;
}

.quantity-control {
    margin-bottom: 1rem;
}

.quantity-selector {
    display: inline-flex;
    align-items: center;
    gap: 0;
    border: 1px solid #e9ecef;
    border-radius: 50px;
    overflow: hidden;
}

.quantity-btn {
    width: 40px;
    height: 44px;
    border: none;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background: #667eea;
    color: white;
}

.quantity-input {
    width: 60px;
    height: 44px;
    text-align: center;
    border: none;
    font-weight: 600;
    font-size: 1rem;
}

.quantity-input:focus {
    outline: none;
}

.btn-add-to-cart {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.btn-add-to-cart:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26, 26, 46, 0.3);
}

.btn-add-to-cart:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.stock-warning {
    margin-top: 1rem;
    padding: 0.75rem;
    background: #fee2e2;
    color: #dc3545;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
}

/* ===== PRODUCT DESCRIPTION ===== */
.product-description {
    margin-top: 1rem;
}

.description-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}

.description-text {
    font-size: 0.85rem;
    color: #6c757d;
    line-height: 1.5;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .product-info {
        position: relative;
        top: 0;
        margin-top: 2rem;
    }
    
    .main-product-image {
        min-height: 400px;
    }
}

@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .product-price-display {
        font-size: 1.25rem;
    }
}
</style>
@endsection