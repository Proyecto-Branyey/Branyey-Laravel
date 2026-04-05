@extends('layouts.app')

@section('title', 'Editar Color - Branyey')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Color</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.colores.update', $colore) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $colore->nombre }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="codigo_hex" class="form-label">Código Hex</label>
                            <input type="color" name="codigo_hex" id="codigo_hex" class="form-control form-control-color" value="{{ $colore->codigo_hex ?? '#000000' }}">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('admin.colores.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection