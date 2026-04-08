@extends('layouts.app')

@section('title', 'Iniciar Sesión - Branyey')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            {{-- Header --}}
            <div class="text-center mb-4">
                <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
                    🔐 BIENVENIDO
                </span>
                <h1 class="fw-black display-5 mb-2">Iniciar Sesión</h1>
                <p class="text-muted">Accede a tu cuenta para continuar comprando</p>
            </div>

            {{-- Tarjeta de login --}}
            <div class="login-card">
                @if (session('status'))
                    <div class="alert-success-card mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error-card mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Credenciales incorrectas. Por favor, verifica tus datos.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Campo de correo/usuario --}}
                    <div class="form-group-login">
                        <label for="login" class="form-label-login">
                            <i class="bi bi-envelope me-1"></i>Correo o usuario
                        </label>
                        <input id="login" type="text" 
                               class="login-input @error('login') is-invalid @enderror" 
                               name="login" value="{{ old('login') }}" 
                               placeholder="Ej: juanperez@correo.com" 
                               required autofocus autocomplete="username">
                        @error('login')
                            <div class="invalid-feedback-login">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Campo de contraseña --}}
                    <div class="form-group-login">
                        <label for="password" class="form-label-login">
                            <i class="bi bi-key me-1"></i>Contraseña
                        </label>
                        <div class="password-wrapper-login">
                            <input id="password" type="password" 
                                   class="login-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Ingresa tu contraseña" 
                                   required autocomplete="current-password">
                            <button type="button" class="password-toggle-login" onclick="togglePassword()">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback-login">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Recordar sesión --}}
                    <div class="remember-group">
                        <label class="remember-checkbox">
                            <input type="checkbox" name="remember" id="remember_me">
                            <span class="checkmark"></span>
                            <span class="remember-text">Recordar sesión</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                <i class="bi bi-question-circle me-1"></i>¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    {{-- Botón de login --}}
                    <div class="login-actions">
                        <button type="submit" class="btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                        </button>
                    </div>

                    {{-- Enlace a registro --}}
                    <div class="login-footer">
                        <p>¿No tienes cuenta? <a href="{{ route('register') }}">Crea una aquí</a></p>
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

/* ===== REMEMBER & FORGOT ===== */
.remember-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1.25rem 0;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.remember-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.8rem;
    color: #6c757d;
}

.remember-checkbox input {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #667eea;
}

.remember-text {
    user-select: none;
}

.forgot-link {
    font-size: 0.75rem;
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.forgot-link:hover {
    color: #764ba2;
    text-decoration: underline;
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
    
    .remember-group {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<script>
// Toggle password visibility
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.querySelector('.password-toggle-login i');
    
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