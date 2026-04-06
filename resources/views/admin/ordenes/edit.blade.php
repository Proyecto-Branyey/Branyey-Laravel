@extends('layouts.admin')
@section('title', 'Editar Orden')
@section('admin-content')
<div class="container py-4">
    <h1 class="h3 mb-4">Editar Orden</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ordenes.update', $orden->id ?? 1) }}">
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
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $orden->fecha ?? '' }}">
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="{{ $orden->estado ?? '' }}">
                </div>
                <button type="submit" class="btn btn-success">Actualizar Orden</button>
                <a href="{{ route('admin.ordenes.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
