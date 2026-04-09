@extends('layouts.app')

@section('title', 'Verificar Correo - Branyey')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            {{-- Header --}}
            <div class="text-center mb-4">
                <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
                    ✉️ VERIFICAR CORREO
                </span>
                <h1 class="fw-black display-5 mb-2">Verifica tu correo electrónico</h1>
                <p class="text-muted">Gracias por registrarte en Branyey</p>
            </div>

            {{-- Tarjeta de verificación --}}
            <div class="verify-card">
                {{-- Mensaje principal --}}
                <div class="alert-info-card mb-4">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Antes de comenzar, por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar.
                </div>

                {{-- Mensaje de éxito --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="alert-success-card mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Se ha enviado un nuevo enlace de verificación a la dirección de correo que proporcionaste durante el registro.
                    </div>
                @endif

                {{-- Instrucciones adicionales --}}
                <div class="info-card mb-4">
                    <div class="d-flex gap-3 align-items-start">
                        <i class="bi bi-info-circle-fill text-secondary mt-1"></i>
                        <div>
                            <strong class="d-block mb-1">¿No recibiste el correo?</strong>
                            <p class="text-muted small mb-0">Revisa tu bandeja de spam o correo no deseado. Si aún no lo encuentras, puedes solicitar un nuevo enlace a continuación.</p>
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="action-buttons">
                    <form method="POST" action="{{ route('verification.send') }}" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn-verify">
                            <i class="bi bi-send me-2"></i>Reenviar verificación
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                        </button>
                    </form>
                </div>

                {{-- Enlace de ayuda --}}
                <div class="verify-footer">
                    <p class="small text-muted mb-0">
                        <i class="bi bi-question-circle me-1"></i>
                        ¿Problemas con la verificación? 
                        <a href="mailto:soporte@branyey.com" class="help-link">Contacta con soporte</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== VERIFY CARD ===== */
.verify-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

/* ===== ALERTS ===== */
.alert-info-card {
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
    padding: 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    border-left: 3px solid #0d6efd;
}

.alert-success-card {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    padding: 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    border-left: 3px solid #10b981;
}

.info-card {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
}

/* ===== BOTONES ===== */
.action-buttons {
    display: flex;
    gap: 1rem;
    margin: 1.5rem 0;
}

.btn-verify {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.85rem 1.75rem;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-verify:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-logout {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.85rem 1.75rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-logout:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== FOOTER ===== */
.verify-footer {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.help-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.help-link:hover {
    text-decoration: underline;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .verify-card {
        padding: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.75rem;
    }
}
</style>
@endsection