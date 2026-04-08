@extends('layouts.admin')

@section('title', 'Editar Talla - Branyey')

@section('admin-content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Talla</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tallas.update', $talla) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $talla->nombre }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="clasificacion_id" class="form-label">Clasificación</label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                                <option value="">Seleccione</option>
                                @foreach($clasificaciones as $clas)
                                    <option value="{{ $clas->id }}" {{ $talla->clasificacion_id == $clas->id ? 'selected' : '' }}>{{ $clas->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('admin.tallas.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection