@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Importar datos desde Excel</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="alert alert-info">
        <strong>Formato del Excel:</strong><br>
        - clasificacion-talla: columna A = nombre (Niño, Dama, Adulto)<br>
        - colores: columna A = nombre, columna B = codigo_hex (opcional)<br>
        - tallas: columna A = nombre, columna B = clasificacion (Niño, Dama, Adulto)<br>
        - estilos-camisa: columna A = nombre
    </div>

    <form action="{{ route('admin.importar.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="tabla" class="form-label">Tabla a importar</label>
            <select name="tabla" id="tabla" class="form-control" required>
                <option value="clasificacion-talla">Clasificación Talla</option>
                <option value="colores">Colores</option>
                <option value="tallas">Tallas</option>
                <option value="estilos-camisa">Estilos Camisa</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Archivo Excel</label>
            <input type="file" name="file" class="form-control" accept=".xlsx" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>
</div>
@endsection
