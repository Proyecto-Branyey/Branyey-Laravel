@extends('layouts.app')

@section('title', 'Finalizar Compra | Branyey')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <h1 class="fw-black text-uppercase italic display-5">Finalizar Compra</h1>
        <p class="text-muted">Estás a un paso de recibir tus prendas. Completa los datos de entrega.</p>
    </div>

    <form action="{{ route('tienda.orden.store') }}" method="POST">
        @csrf
        <div class="row g-5">
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-truck me-2 text-primary"></i> Información de Entrega
                    </h4>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nombre Completo</label>
                            <input type="text" class="form-control form-control-lg rounded-pill bg-light border-0" 
                                   value="{{ $user->name }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Teléfono de Contacto</label>
                            <input type="text" name="telefono" class="form-control form-control-lg rounded-pill @error('telefono') is-invalid @enderror" 
                                   value="{{ old('telefono', $user->telefono) }}" placeholder="Ej: 300 123 4567" required>
                            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control form-control-lg rounded-pill" 
                                   value="Bogotá" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Dirección de Residencia</label>
                            <input type="text" name="direccion" class="form-control form-control-lg rounded-pill @error('direccion') is-invalid @enderror" 
                                   value="{{ old('direccion', $user->direccion) }}" placeholder="Calle, Carrera, Conjunto, Apto..." required>
                            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Departamento / Notas</label>
                            <input type="text" name="departamento" class="form-control form-control-lg rounded-pill" 
                                   value="Cundinamarca" placeholder="Indicaciones adicionales...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 bg-dark text-white rounded-4 p-4 shadow-lg sticky-top" style="top: 2rem;">
                    <h4 class="fw-bold mb-4 italic text-uppercase">Resumen del Pedido</h4>
                    
                    <div class="cart-items-preview mb-4" style="max-height: 300px; overflow-y: auto;">
                        @foreach($cart as $id => $item)
                        <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-3">
                            <img src="{{ asset($item['image']) }}" class="rounded-3 me-3" width="50" height="50" style="object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small fw-bold text-uppercase">{{ $item['name'] }}</h6>
                                <small class="text-secondary">Talla: {{ $item['talla'] }} | Cant: {{ $item['quantity'] }}</small>
                            </div>
                            <span class="fw-bold small">${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Subtotal</span>
                        <span>${{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-secondary">Envío (Bogotá)</span>
                        <span class="text-success fw-bold">GRATIS</span>
                    </div>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h5 mb-0 fw-bold">TOTAL A PAGAR</span>
                        <span class="h3 mb-0 fw-black italic text-warning">${{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg w-100 rounded-pill fw-black text-uppercase py-3 shadow">
                        Confirmar Pedido <i class="bi bi-chevron-right ms-2"></i>
                    </button>
                    
                    <p class="text-center mt-3 mb-0 small text-secondary italic">
                        <i class="bi bi-shield-check me-1"></i> Compra segura protegida por Branyey
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
    .fw-black { font-weight: 900; }
    .italic { font-style: italic; }
    .btn-warning { color: #000; }
    .btn-warning:hover { background-color: #ffca2c; transform: translateY(-2px); transition: 0.3s; }
</style>
@endsection