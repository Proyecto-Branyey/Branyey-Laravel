@extends('layouts.app')

@section('content')

<!-- ===== HERO SECTION ===== -->
<section class="hero-enhanced position-relative overflow-hidden">
    <div class="hero-background"></div>
    <div class="container h-100 position-relative z-2">
        <div class="row align-items-center h-100 min-vh-100">
            <div class="col-lg-6 text-white py-5">
                <div class="animate-fade-in">
                    <span class="badge bg-danger mb-3 px-3 py-2" style="font-size: 0.9rem;">✨ NUEVA COLECCIÓN 2026</span>
                    <h1 class="display-3 fw-900 mb-4 lh-1">
                        <span class="text-gradient">ESTILO</span><br>
                        SIN LÍMITES
                    </h1>
                    <p class="lead fs-5 mb-4 text-white-75">Diseñadas para quien se atreve a marcar la diferencia. Camisas premium que fusionan calidad, confort y moda urbana.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('tienda.catalogo') }}" class="btn btn-light btn-lg px-5 fw-bold rounded-pill shadow-lg hover-lift">
                            <i class="bi bi-shop me-2"></i>EXPLORAR AHORA
                        </a>
                        <button class="btn btn-outline-light btn-lg px-5 fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#videoModal">
                            <i class="bi bi-play-circle me-2"></i>VER COLECCIÓN
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-flex justify-content-end align-items-center position-relative">
                <div class="hero-image-container">
                    @if($destacados->first() && $destacados->first()->imagenes->first())
                        @php
                            $imagenUrl = Storage::url($destacados->first()->imagenes->first()->url);
                        @endphp
                        <img src="{{ $imagenUrl }}" 
                             alt="Colección Branyey" class="img-fluid animate-slide-right" style="max-width: 100%; filter: brightness(1.1); height: auto;">
                    @else
                        <div class="hero-placeholder"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== TRUST INDICATORS ===== -->
<section class="bg-light py-4 border-bottom">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 py-3">
                <i class="bi bi-shield-check text-primary fs-2 mb-2 d-block"></i>
                <small class="text-muted">100% Garantía</small>
                <div class="fw-bold">Satisfacción Asegurada</div>
            </div>
            <div class="col-md-3 py-3">
                <i class="bi bi-truck text-primary fs-2 mb-2 d-block"></i>
                <small class="text-muted">Envío Rápido</small>
                <div class="fw-bold">A toda Colombia</div>
            </div>
            <div class="col-md-3 py-3">
                <i class="bi bi-arrow-counterclockwise text-primary fs-2 mb-2 d-block"></i>
                <small class="text-muted">Devoluciones</small>
                <div class="fw-bold">Fáciles y Gratis</div>
            </div>
            <div class="col-md-3 py-3">
                <i class="bi bi-chat-dots text-primary fs-2 mb-2 d-block"></i>
                <small class="text-muted">Soporte 24/7</small>
                <div class="fw-bold">Estamos aquí para ti</div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CATEGORÍAS DESTACADAS ===== -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5 mb-3">Explora Nuestras Colecciones</h2>
            <p class="text-muted fs-5">Encuentra el estilo perfecto para tu personalidad</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="category-card position-relative overflow-hidden rounded-xl shadow-sm hover-zoom">
                    <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop" 
                         alt="Casual" class="w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay d-flex align-items-end">
                        <div class="w-100 p-4 text-white">
                            <h4 class="fw-bold mb-2">COLECCIÓN CASUAL</h4>
                            <small class="d-block mb-3">Confort para el día a día</small>
                            <a href="{{ route('tienda.catalogo') }}" class="btn btn-sm btn-light rounded-pill">Ver Más →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card position-relative overflow-hidden rounded-xl shadow-sm hover-zoom">
                    <img src="https://images.unsplash.com/photo-1489749798305-4fea3ba63d60?w=500&h=500&fit=crop" 
                         alt="Premium" class="w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay d-flex align-items-end">
                        <div class="w-100 p-4 text-white">
                            <h4 class="fw-bold mb-2">LÍNEA PREMIUM</h4>
                            <small class="d-block mb-3">Lujo y distinción</small>
                            <a href="{{ route('tienda.catalogo') }}" class="btn btn-sm btn-light rounded-pill">Ver Más →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card position-relative overflow-hidden rounded-xl shadow-sm hover-zoom">
                    <img src="https://images.unsplash.com/photo-1618932260643-30b39caf8fa2?w=500&h=500&fit=crop" 
                         alt="Urban" class="w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay d-flex align-items-end">
                        <div class="w-100 p-4 text-white">
                            <h4 class="fw-bold mb-2">URBAN STYLE</h4>
                            <small class="d-block mb-3">Para los atrevidos</small>
                            <a href="{{ route('tienda.catalogo') }}" class="btn btn-sm btn-light rounded-pill">Ver Más →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== DESTACADOS MEJORADO ===== -->
@if($destacados->isNotEmpty())
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-danger mb-2">🔥 LO MÁS VENDIDO</span>
                <h2 class="fw-bold display-5 mb-2">Favoritos de Nuestros Clientes</h2>
                <p class="text-muted">Estos son los productos que cautivaron a miles</p>
            </div>

            <div class="row g-4">
                @foreach($destacados->take(6) as $producto)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card-enhanced h-100">
                            <div class="product-image-wrapper position-relative overflow-hidden rounded-xl">
                                @php
                                    $imagenUrl = $producto->imagenes->first() 
                                        ? Storage::url($producto->imagenes->first()->url)
                                        : 'https://via.placeholder.com/400x500'
                                @endphp
                                <img src="{{ $imagenUrl }}" 
                                     alt="{{ $producto->nombre_comercial }}" class="w-100" style="height: 350px; object-fit: cover;">
                                <div class="product-badge">⭐ BESTSELLER</div>
                                <div class="product-overlay">
                                    <a href="{{ route('tienda.producto.detalle', $producto->id) }}" class="btn btn-light btn-lg rounded-circle shadow-lg">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="mb-2">
                                    <small class="text-muted">{{ $producto->estilo?->nombre ?? 'Estilo' }}</small>
                                </div>
                                <h5 class="fw-bold mb-3">{{ $producto->nombre_comercial }}</h5>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <small class="text-muted ms-2">(128 reseñas)</small>
                                </div>

                                <div class="mb-3 pb-3 border-bottom">
                                    <p class="text-muted small mb-0">{{ Str::limit($producto->descripcion, 60) }}</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="text-primary fw-bold fs-5 mb-1">
                                            ${{ number_format($producto->variantes->first()?->precio_minorista ?? 0, 0, ',', '.') }} COP
                                        </p>
                                        @if(auth()->check() && auth()->user()?->rol?->nombre === 'mayorista')
                                            <small class="text-success">Mayorista: ${{ number_format($producto->variantes->first()?->precio_mayorista ?? 0, 0, ',', '.') }}</small>
                                        @endif
                                    </div>
                                    @if($producto->variantes->sum('stock') > 0)
                                        <span class="badge bg-success">En Stock</span>
                                    @else
                                        <span class="badge bg-secondary">Agotado</span>
                                    @endif
                                </div>

                                <a href="{{ route('tienda.producto.detalle', $producto->id) }}" class="btn btn-dark w-100 rounded-pill fw-bold py-2 hover-lift">
                                    + Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('tienda.catalogo') }}" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold">
                    Ver Todo el Catálogo <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
@endif

<!-- ===== CARACTERÍSTICAS ===== -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold display-5 mb-4">¿Por Qué Elegir Branyey?</h2>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="feature-item d-flex">
                            <div class="feature-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                <i class="bi bi-check text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Calidad Premium</h5>
                                <p class="text-muted mb-0">Telas de alta calidad importadas con acabados impecables.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-item d-flex">
                            <div class="feature-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                <i class="bi bi-check text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Diseños Exclusivos</h5>
                                <p class="text-muted mb-0">Colecciones diseñadas por creadores independientes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-item d-flex">
                            <div class="feature-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                <i class="bi bi-check text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Precio Justo</h5>
                                <p class="text-muted mb-0">Precios competitivos sin comprometer la calidad.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-item d-flex">
                            <div class="feature-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                <i class="bi bi-check text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Comunidad Global</h5>
                                <p class="text-muted mb-0">Únete a miles de satisfechos clientes en todo el mundo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?w=600&h=600&fit=crop" 
                     alt="Equipo Branyey" class="img-fluid rounded-xl shadow-lg" style="border-radius: 20px;">
            </div>
        </div>
    </div>
</section>



<!-- ===== MODAL VIDEO ===== -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== VARIABLES ===== */
    :root {
        --primary: #0d6efd;
        --secondary: #6c757d;
        --dark: #212529;
        --light: #f8f9fa;
        --danger: #dc3545;
    }

    /* ===== HERO SECTION ===== */
    .hero-enhanced {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        z-index: 1;
    }

    .hero-enhanced::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(13, 110, 253, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
        z-index: 0;
    }

    .hero-enhanced::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(220, 53, 69, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
        z-index: 0;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(30px); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-slide-right {
        animation: slideRight 0.8s ease-out;
    }

    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    }

    /* ===== HERO IMAGE ===== */
    .hero-image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 500px;
        width: 100%;
        padding: 20px;
    }

    .hero-image-container img {
        max-height: 600px;
        width: auto;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    }

    .hero-placeholder {
        width: 400px;
        height: 500px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    }

    /* ===== CATEGORÍAS ===== */
    .category-card {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
        display: flex;
        align-items: flex-end;
    }

    .hover-zoom:hover {
        transform: scale(1.05);
    }

    .rounded-xl {
        border-radius: 20px;
    }

    /* ===== PRODUCT CARDS ===== */
    .product-card-enhanced {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .product-card-enhanced:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transform: translateY(-8px);
    }

    .product-image-wrapper {
        position: relative;
        aspect-ratio: 4/5;
        background: #f8f9fa;
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.7);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card-enhanced:hover .product-overlay {
        opacity: 1;
    }

    /* ===== FEATURES ===== */
    .feature-item {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        background: #f0f0f0;
        transform: translateX(10px);
    }

    .feature-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    /* ===== UTILITY ===== */
    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }

    .text-white-50 {
        color: rgba(255, 255, 255, 0.5);
    }

    .fw-900 {
        font-weight: 900;
    }

    .min-vh-100 {
        min-height: 100vh;
    }

    /* ===== ANIMATIONS ===== */
    @media (prefers-reduced-motion: no-preference) {
        .product-card-enhanced {
            animation: fadeIn 0.5s ease-out;
        }
    }

    .z-2 {
        z-index: 2;
    }
</style>

@endsection