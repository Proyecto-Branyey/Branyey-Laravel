@extends('layouts.app')

@section('title', 'Restablecer Contraseña - Branyey')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            {{-- Header --}}
            <div class="text-center mb-4">
                <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
                    🔐 RESTABLECER CONTRASEÑA
                </span>
                <h1 class="fw-black display-5 mb-2">Nueva Contraseña</h1>
                <p class="text-muted">Ingresa tu nueva contraseña para acceder a tu cuenta</p>
            </div>

            {{-- Tarjeta de restablecimiento --}}
            <div class="login-card">
                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert-error-card mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    {{-- Token oculto --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Campo de correo electrónico --}}
                    <div class="form-group-login">
                        <label for="email" class="form-label-login">
                            <i class="bi bi-envelope me-1"></i>Correo electrónico
                        </label>
                        <input id="email" type="email" 
                               class="login-input @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email', $request->email) }}" 
                               placeholder="ejemplo@correo.com" 
                               required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback-login">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Campo de nueva contraseña --}}
                    <div class="form-group-login">
                        <label for="password" class="form-label-login">
                            <i class="bi bi-key me-1"></i>Nueva contraseña
                        </label>
                        <div class="password-wrapper-login">
                            <input id="password" type="password" 
                                   class="login-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Mínimo 8 caracteres" 
                                   required autocomplete="new-password">
                            <button type="button" class="password-toggle-login" onclick="togglePassword('password')">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <div class="form-hint">
                            <i class="bi bi-info-circle me-1"></i>La contraseña debe tener al menos 8 caracteres
                        </div>
                        @error('password')
                            <div class="invalid-feedback-login">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Campo de confirmar contraseña --}}
                    <div class="form-group-login">
                        <label for="password_confirmation" class="form-label-login">
                            <i class="bi bi-check-circle me-1"></i>Confirmar contraseña
                        </label>
                        <div class="password-wrapper-login">
                            <input id="password_confirmation" type="password" 
                                   class="login-input" 
                                   name="password_confirmation" 
                                   placeholder="Repite tu nueva contraseña" 
                                   required autocomplete="new-password">
                            <button type="button" class="password-toggle-login" onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Botón de restablecer --}}
                    <div class="login-actions">
                        <button type="submit" class="btn-login">
                            <i class="bi bi-check-lg me-2"></i>Restablecer contraseña
                        </button>
                    </div>

                    {{-- Enlace a login --}}
                    <div class="login-footer">
                        <p><i class="bi bi-arrow-left me-1"></i> <a href="{{ route('login') }}">Volver al inicio de sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== LOGIN CARD ===== */
.login-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

/* ===== ALERTS ===== */
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

.alert-error-card ul {
    padding-left: 1.5rem;
    margin: 0;
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

.form-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== PASSWORD TOGGLE ===== */
.password-wrapper-login {
    position: relative;
}

.password-toggle-login {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.3s ease;
}

.password-toggle-login:hover {
    color: #667eea;
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

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = input.parentElement.querySelector('.password-toggle-login i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}
</script>
@endsection