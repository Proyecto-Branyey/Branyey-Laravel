@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-people me-2"></i>Clientes</h2>
        <a href="{{ route('admin.clientes.create') }}" class="btn btn-dark shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Nuevo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>¡Hecho!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                    <tr>
                        <td class="ps-4">#{{ $cliente->id }}</td>
                        <td>
                            <a href="{{ route('admin.clientes.show', $cliente->id) }}" class="d-block p-2 rounded-2 fw-bold text-dark text-decoration-none hover-bg-light position-relative" style="transition:background 0.2s;">
                                {{ $cliente->username }}
                                <small class="text-muted d-block fw-normal" style="font-size: 0.85em;">{{ $cliente->nombre_completo }}</small>
                                <span class="stretched-link"></span>
                            </a>
                        </td>
                        <td>{{ $cliente->email }}</td>
                        <td><span class="badge bg-secondary-subtle text-secondary border">{{ $cliente->rol?->nombre ?? 'N/A' }}</span></td>
                        <td>{{ $cliente->telefono ?? '-' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.clientes.show', $cliente->id) }}" class="btn btn-sm btn-white border" title="Ver cliente"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.clientes.edit', $cliente->id) }}" class="btn btn-sm btn-white border" title="Editar cliente"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-white border text-danger" title="Eliminar cliente"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No hay clientes registrados aún.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
