@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <h1>Editar Usuario</h1>
    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre completo</label>
            <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" value="{{ old('nombre_completo', $usuario->nombre_completo) }}">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $usuario->telefono) }}">
        </div>
        <div class="mb-3">
            <label for="direccion_defecto" class="form-label">Dirección</label>
            <input type="text" name="direccion_defecto" id="direccion_defecto" class="form-control" value="{{ old('direccion_defecto', $usuario->direccion_defecto) }}">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="ciudad_defecto" class="form-label">Ciudad</label>
                <input type="text" name="ciudad_defecto" id="ciudad_defecto" class="form-control" value="{{ old('ciudad_defecto', $usuario->ciudad_defecto) }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $usuario->username) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol</label>
            <select name="rol_id" id="rol_id" class="form-control" required>
                <option value="">Seleccione un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}" {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
