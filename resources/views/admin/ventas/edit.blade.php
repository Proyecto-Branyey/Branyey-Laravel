@extends('layouts.admin')
@section('title', 'Editar Venta')
@section('admin-content')
<div class="container py-4">
    <h1 class="h3 mb-4">Editar Venta</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ventas.update', $venta->id ?? 1) }}">
                @csrf
                @method('PUT')
                {{-- Campos del formulario de edición --}}
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente_id" name="cliente_id">
                        {{-- Opciones de clientes --}}
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $venta->fecha ?? '' }}">
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ $venta->total ?? '' }}">
                </div>
                <button type="submit" class="btn btn-success">Actualizar Venta</button>
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
