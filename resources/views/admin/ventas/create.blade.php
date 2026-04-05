@extends('layouts.admin')
@section('title', 'Registrar Venta')
@section('admin-content')
<div class="container py-4">
    <h1 class="h3 mb-4">Registrar Nueva Venta</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ventas.store') }}">
                @csrf
                {{-- Campos del formulario de venta --}}
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente_id" name="cliente_id">
                        {{-- Opciones de clientes --}}
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" step="0.01" class="form-control" id="total" name="total">
                </div>
                <button type="submit" class="btn btn-success">Guardar Venta</button>
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
