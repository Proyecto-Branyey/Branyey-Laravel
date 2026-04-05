@extends('layouts.app')

@section('title', 'Catálogo Completo - Branyey')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Filtros --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 100px; border-radius: 15px;">
                <h5 class="fw-bold mb-4 italic">FILTRAR</h5>
                <form action="{{ route('tienda.catalogo') }}" method="GET">
                    {{-- Estilo --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Estilo de Prenda</label>
                        <div class="list-group list-group-flush rounded-3 overflow-hidden shadow-sm">
                            <label class="list-group-item list-group-item-action border-0 {{ !request('estilo_id') ? 'active bg-dark text-white' : '' }} cursor-pointer">
                                <input type="radio" name="estilo_id" value="" class="d-none" onchange="this.form.submit()" {{ !request('estilo_id') ? 'checked' : '' }}>
                                Todos los estilos
                            </label>
                            @foreach($estilos as $estilo)
                                <label class="list-group-item list-group-item-action border-0 {{ request('estilo_id') == $estilo->id ? 'active bg-dark text-white' : '' }} cursor-pointer">
                                    <input type="radio" name="estilo_id" value="{{ $estilo->id }}" class="d-none" onchange="this.form.submit()" {{ request('estilo_id') == $estilo->id ? 'checked' : '' }}>
                                    {{ $estilo->nombre }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Clasificación de Talla (Género) --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Categoría</label>
                        <div class="list-group list-group-flush rounded-3 overflow-hidden shadow-sm">
                            <label class="list-group-item list-group-item-action border-0 {{ !request('clasificacion_id') ? 'active bg-dark text-white' : '' }} cursor-pointer">
                                <input type="radio" name="clasificacion_id" value="" class="d-none" onchange="this.form.submit()" {{ !request('clasificacion_id') ? 'checked' : '' }}>
                                Todas las categorías
                            </label>
                            @foreach($clasificaciones as $clasif)
                                <label class="list-group-item list-group-item-action border-0 {{ request('clasificacion_id') == $clasif->id ? 'active bg-dark text-white' : '' }} cursor-pointer">
                                    <input type="radio" name="clasificacion_id" value="{{ $clasif->id }}" class="d-none" onchange="this.form.submit()" {{ request('clasificacion_id') == $clasif->id ? 'checked' : '' }}>
                                    {{ $clasif->nombre }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    @if(request()->anyFilled(['estilo_id', 'clasificacion_id']))
                        <a href="{{ route('tienda.catalogo') }}" class="btn btn-link btn-sm text-decoration-none text-danger p-0 fw-bold mt-2">
                            × LIMPIAR FILTROS
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Productos --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0 italic text-uppercase">Colección <span class="text-muted">/ Branyey</span></h2>
                <p class="text-muted mb-0 small fw-bold uppercase">Items: {{ $productos->total() }}</p>
            </div>

            <div class="row g-4">
                @forelse($productos as $producto)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm product-hover" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative overflow-hidden" style="height: 380px; background-color: #f8f9fa;">
                                <a href="{{ route('tienda.producto.detalle', $producto->id) }}">
                                    @php $img = $producto->imagenes->first(); @endphp
                                    @if($img)
                                        <img src="{{ Storage::url($img->url) }}" class="w-100 h-100 img-zoom" style="object-fit: cover; object-position: top;" alt="{{ $producto->nombre_comercial }}">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small fw-bold italic" style="background: #eee;">NO IMAGE</div>
                                    @endif
                                </a>
                            </div>

                            <div class="card-body text-center">
                                <span class="text-uppercase text-muted fw-bold mb-1 d-block small" style="letter-spacing: 2px;">
                                    {{ $producto->estilo->nombre ?? 'Colección' }}
                                </span>
                                <h6 class="card-title fw-bold text-dark text-uppercase mb-3">{{ $producto->nombre_comercial }}</h6>
                                <h5 class="fw-bold text-dark mb-3">
                                    @php
                                        $precios = $producto->variantes->map(function($v) {
                                            return $v->getPrecioActual();
                                        });
                                        $minPrecio = $precios->min();
                                        $maxPrecio = $precios->max();
                                    @endphp
                                    ${{ number_format($minPrecio, 0, ',', '.') }} COP
                                    @if($minPrecio != $maxPrecio)
                                        - ${{ number_format($maxPrecio, 0, ',', '.') }} COP
                                    @endif
                                </h5>
                                <a href="{{ route('tienda.producto.detalle', $producto->id) }}" class="btn btn-dark w-100 rounded-pill py-2 fw-bold text-uppercase small">
                                    Ver Pieza
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="py-5 border border-2 border-dashed rounded-5">
                            <h4 class="text-muted fw-bold italic mb-0">Sin resultados</h4>
                            <p class="text-muted small uppercase mt-2">Aún no existe este producto.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $productos->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer { cursor: pointer; }
.product-hover { transition: transform 0.3s ease; }
.product-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
.img-zoom { transition: transform 0.5s ease; }
.product-hover:hover .img-zoom { transform: scale(1.05); }
.italic { font-style: italic; }
</style>
@endsection