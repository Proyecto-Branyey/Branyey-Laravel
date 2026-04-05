@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-dark text-white p-4">
                    <h4 class="mb-0 fw-bold">Editar Cliente</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.clientes.update', $cliente->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nombre de usuario</label>
                            <input type="text" name="username" class="form-control" required value="{{ old('username', $cliente->username) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="nombre_completo" class="form-control" required value="{{ old('nombre_completo', $cliente->nombre_completo) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email', $cliente->email) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion_defecto" class="form-control" value="{{ old('direccion_defecto', $cliente->direccion_defecto) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="ciudad_defecto" class="form-control" value="{{ old('ciudad_defecto', $cliente->ciudad_defecto) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Departamento</label>
                            <input type="text" name="departamento_defecto" class="form-control" value="{{ old('departamento_defecto', $cliente->departamento_defecto) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select name="rol_id" class="form-select" required>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('rol_id', $cliente->rol_id) == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.clientes.index') }}" class="btn btn-light">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
