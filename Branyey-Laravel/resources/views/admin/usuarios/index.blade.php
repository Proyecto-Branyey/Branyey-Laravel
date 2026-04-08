@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <h1 class="mb-4">Usuarios</h1>
    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.usuarios.papelera') }}" class="btn btn-outline-danger">Papelera</a>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">Nuevo Usuario</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombre_completo }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->rol->nombre ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $usuarios->links() }}
</div>
@endsection
