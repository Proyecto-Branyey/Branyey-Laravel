@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid px-0">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-people-fill me-2"></i>Usuarios
            </h1>
            <p class="text-muted small mb-0">Gestiona los usuarios registrados en la plataforma</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.usuarios.papelera') }}" class="btn-action-outline">
                <i class="bi bi-trash3 me-1"></i> Papelera
            </a>
            <a href="{{ route('admin.usuarios.create') }}" class="btn-action-primary">
                <i class="bi bi-person-plus me-1"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('admin.usuarios.index') }}" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="filter-label">
                        <i class="bi bi-search me-1"></i> Buscar
                    </label>
                    <input type="text" name="search" class="filter-input" 
                           placeholder="Nombre, usuario o email..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="bi bi-person-badge me-1"></i> Rol
                    </label>
                    <select name="rol" class="filter-select">
                        <option value="">Todos los roles</option>
                        <option value="administrador" {{ request('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="mayorista" {{ request('rol') == 'mayorista' ? 'selected' : '' }}>Mayorista</option>
                        <option value="minorista" {{ request('rol') == 'minorista' ? 'selected' : '' }}>Minorista</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="bi bi-toggle-on me-1"></i> Estado
                    </label>
                    <select name="estado" class="filter-select">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn-filter-apply w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <div class="d-flex gap-2">
                            @if(request()->anyFilled(['search', 'rol', 'estado']))
                                <a href="{{ route('admin.usuarios.index') }}" class="btn-filter-clear flex-grow-1 text-center">
                                    <i class="bi bi-x-circle me-1"></i> Limpiar
                                </a>
                            @endif
                            <a href="{{ route('admin.usuarios.exportar.pdf', request()->query()) }}" class="btn-export-pdf flex-grow-1 text-center" target="_blank">
                                <i class="bi bi-file-pdf me-1"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert-success-card mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabla de usuarios --}}
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-name">Nombre</th>
                    <th class="col-user">Usuario</th>
                    <th class="col-email">Email</th>
                    <th class="col-role">Rol</th>
                    <th class="col-status">Estado</th>
                    <th class="col-actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td class="col-id">#{{ $usuario->id }}</td>
                        <td class="col-name">
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ substr($usuario->nombre_completo ?? $usuario->username, 0, 2) }}
                                </div>
                                <span>{{ $usuario->nombre_completo ?? 'No registrado' }}</span>
                            </div>
                        </td>
                        <td class="col-user">{{ $usuario->username }}</td>
                        <td class="col-email">{{ $usuario->email }}</td>
                        <td class="col-role">
                            @php
                                $roleColors = [
                                    'administrador' => 'danger',
                                    'mayorista' => 'warning',
                                    'minorista' => 'success'
                                ];
                                $color = $roleColors[$usuario->rol->nombre ?? 'minorista'] ?? 'secondary';
                            @endphp
                            <span class="role-badge role-{{ $color }}">
                                {{ ucfirst($usuario->rol->nombre ?? 'Minorista') }}
                            </span>
                        </td>
                        <td class="col-status">
                            @if($usuario->activo)
                                <span class="status-badge active">
                                    <i class="bi bi-check-circle-fill me-1"></i> Activo
                                </span>
                            @else
                                <span class="status-badge inactive">
                                    <i class="bi bi-x-circle-fill me-1"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="col-actions">
                            <div class="action-buttons">
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="action-btn edit" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')" title="Eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <i class="bi bi-people fs-1 text-muted"></i>
                                <p class="mt-3 mb-0">No se encontraron usuarios</p>
                                <small class="text-muted">Prueba con otros filtros o crea un nuevo usuario</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pagination-wrapper mt-4">
        {{ $usuarios->appends(request()->query())->links() }}
    </div>
</div>

<style>
/* ===== FILTROS ===== */
.filters-card {
    background: white;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.filter-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.filter-input, .filter-select {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-filter-apply {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-filter-apply:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: translateY(-1px);
}

.btn-filter-clear {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-filter-clear:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

.btn-export-pdf {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-export-pdf:hover {
    background: #bb2d3b;
    transform: translateY(-1px);
    color: white;
}
/* ===== BOTONES PRINCIPALES ===== */
.btn-action-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-primary:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: translateY(-1px);
    color: white;
}

.btn-action-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-outline:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== ALERTAS ===== */
.alert-success-card, .alert-error-card {
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.alert-success-card {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-left: 3px solid #10b981;
}

.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-left: 3px solid #dc3545;
}

/* ===== TABLA ===== */
.table-container {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    padding: 1rem 1rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.85rem;
}

.admin-table tr:hover {
    background: #fafbfc;
}

/* Columnas específicas */
.col-id { width: 60px; }
.col-name { width: 200px; }
.col-user { width: 150px; }
.col-email { width: 220px; }
.col-role { width: 120px; }
.col-status { width: 100px; }
.col-actions { width: 80px; }

/* User cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
}

/* Role badges */
.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
.role-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
.role-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-badge.inactive {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.action-btn.edit {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.action-btn.edit:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.action-btn.delete {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.action-btn.delete:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-2px);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

/* Paginación */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    margin-bottom: 0;
}

/* Responsive */
@media (max-width: 992px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
    
    .col-id, .col-name, .col-user, .col-email, .col-role, .col-status, .col-actions {
        min-width: 100px;
    }
}

@media (max-width: 768px) {
    .filters-card .row > div {
        margin-bottom: 0.75rem;
    }
    
    .btn-filter-apply, .btn-filter-clear {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection