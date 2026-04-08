@extends('layouts.app')

@section('title', 'Mi Perfil - Branyey')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="text-center mb-5">
        <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
            👤 MI CUENTA
        </span>
        <h1 class="fw-black display-5 mb-2">Mi Perfil</h1>
        <p class="text-muted">Gestiona tu información personal y preferencias</p>
    </div>

    <div class="row g-4">
        {{-- Columna izquierda - Información Personal --}}
        <div class="col-lg-6">
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-icon-wrapper">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h3 class="profile-card-title">Información Personal</h3>
                        <p class="profile-card-subtitle">Actualiza tus datos de contacto</p>
                    </div>
                </div>
                <div class="profile-card-body">
                    @include('profile.partials.update-profile-information-form', ['user' => $user])
                </div>
            </div>
        </div>

        {{-- Columna derecha - Cambiar Contraseña --}}
        <div class="col-lg-6">
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-icon-wrapper" style="background: linear-gradient(135deg, #764ba2, #667eea);">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div>
                        <h3 class="profile-card-title">Seguridad</h3>
                        <p class="profile-card-subtitle">Actualiza tu contraseña</p>
                    </div>
                </div>
                <div class="profile-card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Sección de Datos y Eliminación --}}
        <div class="col-12">
            <div class="profile-card-actions">
                <div class="row g-4 align-items-center">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center gap-3">
                            <div class="action-icon">
                                <i class="bi bi-database"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Descargar mis datos</h5>
                                <p class="text-muted small mb-0">Obtén un archivo PDF con toda tu información personal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <a href="{{ route('profile.datos.pdf') }}" class="btn-action-primary">
                            <i class="bi bi-download me-2"></i>Descargar PDF
                        </a>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <div class="row g-4 align-items-center">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center gap-3">
                            <div class="action-icon danger">
                                <i class="bi bi-trash3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-danger">Eliminar cuenta</h5>
                                <p class="text-muted small mb-0">Desactivar tu cuenta, no borra tus pedidos ni historial</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <button type="button" class="btn-action-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="bi bi-exclamation-triangle me-2"></i>Desactiva tu cuenta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Confirmación para Eliminar Cuenta --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <div class="delete-icon-wrapper mx-auto mb-4">
                    <i class="bi bi-trash3"></i>
                </div>
                <h4 class="fw-bold mb-3">¿Eliminar tu cuenta?</h4>
                <p class="text-muted mb-4">Esta acción es reversible perderas acceso al sistema.</p>
                <div class="alert alert-warning small">
                    <i class="bi bi-info-circle me-2"></i>
                    Puedes descargar tus datos en caso de pedidos pendientes
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
/* ===== PROFILE CARDS ===== */
.profile-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    height: 100%;
}

.profile-card:hover {
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.1);
    border-color: rgba(102, 126, 234, 0.2);
}

.profile-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.5rem 0 1.5rem;
    margin-bottom: 0.5rem;
}

.profile-icon-wrapper {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.25);
}

.profile-icon-wrapper i {
    font-size: 1.8rem;
    color: white;
}

.profile-card-title {
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
    color: #1a1a2e;
}

.profile-card-subtitle {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0;
}

.profile-card-body {
    padding: 1rem 1.5rem 1.5rem 1.5rem;
}

/* ===== ACTION CARD ===== */
.profile-card-actions {
    background: white;
    border-radius: 24px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    margin-top: 0;
}

.action-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-icon i {
    font-size: 1.4rem;
    color: #667eea;
}

.action-icon.danger {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
}

.action-icon.danger i {
    color: #dc3545;
}

.btn-action-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-action-danger {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.5rem;
    background: transparent;
    color: #dc3545;
    border: 1.5px solid #dc3545;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    background: white;
}

.btn-action-danger:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
}

.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e9ecef, transparent);
    margin: 1.5rem 0;
}

/* ===== MODAL ELIMINAR ===== */
.delete-icon-wrapper {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-icon-wrapper i {
    font-size: 2.5rem;
    color: #dc3545;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .profile-card-header {
        flex-direction: column;
        text-align: center;
    }
    
    .btn-action-primary,
    .btn-action-danger {
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
    }
    
    .text-md-end {
        text-align: center !important;
    }
    
    .profile-card-actions .row > div {
        text-align: center;
    }
    
    .d-flex.align-items-center.gap-3 {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection