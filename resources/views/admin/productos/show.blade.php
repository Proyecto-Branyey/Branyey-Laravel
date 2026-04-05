@extends('layouts.admin')

@section('title', $producto->nombre_comercial . ' - Admin')

@section('admin-content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-dark text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold">{{ $producto->nombre_comercial }}</h3>
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Estilo</h6>
                            <p class="fw-bold">{{ $producto->estilo?->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted fw-bold small text-uppercase">Clasificación de Talla</h6>
                            <p class="fw-bold">{{ $producto->clasificacionTalla->nombre ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($producto->descripcion)
                        <div class="mb-4">
                            <h6 class="text-muted fw-bold small text-uppercase">Descripción</h6>
                            <p>{{ $producto->descripcion }}</p>
                        </div>
                    @endif

                    <!-- Imágenes -->
                    @if($producto->imagenes->count() > 0)
                        <div class="mb-4">
                            <h6 class="text-muted fw-bold small text-uppercase mb-3">Imágenes</h6>
                            <div class="row g-3">
                                @foreach($producto->imagenes as $imagen)
                                    <div class="col-md-4">
                                        <img src="{{ Storage::url($imagen->url) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $producto->nombre_comercial }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Variantes (Tallas + Colores) -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold small text-uppercase mb-3">Variantes (Talla + Color + Precio + Stock)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Talla</th>
                                        <th>Color</th>
                                        <th>Precio Minorista</th>
                                        <th>Precio Mayorista</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($producto->variantes as $variante)
                                        <tr>
                                            <td class="fw-bold">{{ $variante->talla?->nombre ?? 'Sin talla' }}</td>
                                            <td>
                                                @foreach($variante->colores as $color)
                                                    <span class="badge" style="background-color: {{ $color->codigo_hex }}; color: {{ $color->codigo_hex == '#ffffff' || $color->codigo_hex == '#fff' ? '#000' : '#fff' }}">
                                                        {{ $color->nombre }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>${{ number_format($variante->precio_minorista, 0, ',', '.') }} COP</td>
                                            <td>${{ number_format($variante->precio_mayorista, 0, ',', '.') }} COP</td>
                                            <td>
                                                @if($variante->stock > 0)
                                                    <span class="badge bg-success">{{ $variante->stock }} unidades</span>
                                                @else
                                                    <span class="badge bg-danger">Agotado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="d-flex gap-2 justify-content-between border-top pt-4">
                        <div>
                            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Editar
                            </a>
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                        </div>
                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
