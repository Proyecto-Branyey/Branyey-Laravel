@extends('layouts.admin')

@section('title', 'Papelera de Usuarios - Branyey')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-trash3-fill me-2"></i>Papelera de Usuarios
            </h1>
            <p class="text-muted small mb-0">Usuarios desactivados que pueden ser reactivados</p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
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

    {{-- Tabla de usuarios inactivos --}}
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-name">Nombre</th>
                    <th class="col-user">Usuario</th>
                    <th class="col-email">Email</th>
                    <th class="col-role">Rol</th>
                    <th class="col-actions">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td class="col-id">#{{ $usuario->id }}</td>
                        <td class="col-name">
                            <div class="user-cell">
                                <div class="user-avatar trash-avatar">
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
                        <td class="col-actions">
                            <form action="{{ route('admin.usuarios.activar', $usuario->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="action-btn restore" onclick="return confirm('¿Reactivar este usuario?')" title="Reactivar">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state-cell">
                            <div class="empty-state">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="mt-3 mb-0">No hay usuarios inactivos en la papelera</p>
                                <small class="text-muted">Los usuarios desactivados aparecerán aquí</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* ===== TABLA ===== */
.table-container {
    background: white;
    border-radius: 24px;
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

.user-avatar.trash-avatar {
    background: linear-gradient(135deg, #6c757d, #495057);
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

/* Action buttons */
.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.action-btn.restore {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.action-btn.restore:hover {
    background: #10b981;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* ===== ALERTAS ===== */
.alert-success-card {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    border-left: 3px solid #10b981;
}

.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    border-left: 3px solid #dc3545;
}

/* ===== BOTONES ===== */
.btn-action-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
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

/* ===== EMPTY STATE ===== */
.empty-state-cell {
    text-align: center !important;
    padding: 3rem !important;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    opacity: 0.5;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
    
    .col-id, .col-name, .col-user, .col-email, .col-role, .col-actions {
        min-width: 100px;
    }
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endsection