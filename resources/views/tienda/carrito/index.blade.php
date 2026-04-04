@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="container py-5">
    <h1 class="fw-black text-uppercase italic mb-5">Tu Carrito</h1>

    @if(count($cart) > 0)
        <div class="table-responsive shadow-sm rounded-4 bg-white p-4">
            <table class="table align-middle">
                <thead class="text-uppercase small fw-bold text-muted">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $details)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($details['image']) }}" width="60" class="rounded-3 me-3">
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $details['name'] }}</p>
                                        <small class="text-muted">TALLA: {{ $details['talla'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($details['price'], 0, ',', '.') }}</td>
                            <td style="width: 150px;">
                                <form action="{{ route('tienda.cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control form-control-sm me-2">
                                    <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-arrow-clockwise"></i></button>
                                </form>
                            </td>
                            <td class="fw-bold">${{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            <td class="text-end">
                                <form action="{{ route('tienda.cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
                <a href="{{ route('tienda.catalogo') }}" class="btn btn-outline-dark rounded-pill px-4">
                    Seguir Comprando
                </a>
                <div class="text-end">
                    <p class="text-muted mb-0 small">Total a pagar:</p>
                    <h3 class="fw-black mb-3">${{ number_format($total, 0, ',', '.') }}</h3>
                    <a href="{{ route('tienda.checkout') }}" class="btn btn-dark btn-lg rounded-pill px-5 text-uppercase fw-black shadow-lg">
                        Finalizar Compra
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 shadow-sm rounded-4 bg-white">
            <h2 class="fw-bold">Tu carrito está vacío</h2>
            <a href="{{ route('tienda.catalogo') }}" class="btn btn-dark mt-3 rounded-pill px-5">Ir al Catálogo</a>
        </div>
    @endif
</div>
@endsection