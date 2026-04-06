@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mis Pedidos</h2>
    @if($ventas->isEmpty())
        <div class="alert alert-info">No tienes pedidos registrados.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Factura</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                    <td>{!! $venta->estado_badge !!}</td>
                    <td>
                        <a href="{{ route('tienda.pedidos.factura', $venta->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Ver Factura
                        </a>
                    </td>
                    <td>
                        @if($venta->estado === App\Models\Venta::ESTADO_ENVIADO)
                        <form action="{{ route('tienda.pedidos.recibido', $venta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Marcar como recibido</button>
                        </form>
                        @elseif($venta->estado === App\Models\Venta::ESTADO_ENTREGADO)
                            <span class="text-success">Recibido</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
