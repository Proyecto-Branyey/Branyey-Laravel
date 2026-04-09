@extends('layouts.app')

@section('title', 'Recuperar Contraseña - Branyey')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            {{-- Header --}}
            <div class="text-center mb-4">
                <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
                    🔐 RECUPERAR CONTRASEÑA
                </span>
                <h1 class="fw-black display-5 mb-2">¿Olvidaste tu contraseña?</h1>
                <p class="text-muted">Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla</p>
            </div>

            {{-- Tarjeta de recuperación --}}
            <div class="login-card">
                {{-- Mensaje de sesión --}}
                @if (session('status'))
                    <div class="alert-success-card mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert-error-card mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Campo de correo electrónico --}}
                    <div class="form-group-login">
                        <label for="email" class="form-label-login">
                            <i class="bi bi-envelope me-1"></i>Correo electrónico
                        </label>
                        <input id="email" type="email" 
                               class="login-input @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               placeholder="ejemplo@correo.com" 
                               required autofocus>
                        @error('email')
                            <div class="invalid-feedback-login">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Botón de enviar --}}
                    <div class="login-actions">
                        <button type="submit" class="btn-login">
                            <i class="bi bi-send me-2"></i>Enviar enlace de recuperación
                        </button>
                    </div>

                    {{-- Enlace a login --}}
                    <div class="login-footer">
                        <p><i class="bi bi-arrow-left me-1"></i> <a href="{{ route('login') }}">Volver al inicio de sesión</a></p>
                    </div>
                </form>
            </div>

            {{-- Información adicional --}}
            <div class="text-center mt-4">
                <p class="small text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Revisa tu bandeja de entrada y también la carpeta de spam.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== LOGIN CARD (mismos estilos que el login) ===== */
.login-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

/* ===== ALERTS ===== */
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

/* ===== FORM GROUPS ===== */
.form-group-login {
    margin-bottom: 1.25rem;
}

.form-label-login {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.login-input {
    width: 100%;
    padding: 0.85rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.login-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.login-input.is-invalid {
    border-color: #dc3545;
    background: #fff5f5;
}

.invalid-feedback-login {
    font-size: 0.7rem;
    margin-top: 0.5rem;
    color: #dc3545;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* ===== LOGIN BUTTON ===== */
.login-actions {
    margin-top: 1.5rem;
}

.btn-login {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.85rem 1.75rem;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-login:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

/* ===== FOOTER ===== */
.login-footer {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
    font-size: 0.8rem;
}

.login-footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.login-footer a:hover {
    text-decoration: underline;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .login-card {
        padding: 1.5rem;
    }
}
</style>
@endsection