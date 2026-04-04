@extends('layouts.app')

@section('content')
<section class="hero d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-1 fw-bold text-white mb-3">BRANYEY</h1>
                <p class="lead fs-3 text-white-50 mb-5">Estilo urbano con la esencia que buscas.</p>
                <a href="{{ route('tienda.catalogo') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold shadow-lg">
                    EXPLORAR CATÁLOGO COMPLETO
                </a>
            </div>
        </div>
    </div>
</section>

@if($destacados->isNotEmpty())
    <section class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase" style="letter-spacing: 3px;">Lo Más Vendido</h2>
            <div class="mx-auto bg-dark" style="height: 3px; width: 60px;"></div>
        </div>

        <div class="row">
            @foreach($destacados as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden product-card">
                        <img src="{{ $producto->imagenes->first()->url_completa ?? 'https://via.placeholder.com/400x500' }}" 
                             class="card-img-top" style="height: 400px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-2">{{ $producto->nombre_comercial }}</h5>
                            <p class="text-primary fw-bold fs-5">
                                ${{ number_format($producto->estilo->precio_base_minorista, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('tienda.producto.detalle', $producto->id) }}" class="btn btn-outline-dark rounded-pill px-4">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

<style>
    .hero { 
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/fondo.png') }}') center/cover no-repeat; 
        min-height: 85vh; 
    }
    .product-card { transition: transform 0.3s ease; }
    .product-card:hover { transform: translateY(-10px); }
</style>
@endsection