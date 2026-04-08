<section>
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="bi bi-shield-lock-fill me-2"></i>Cambiar contraseña
        </h4>
        <p class="text-muted mb-0">Asegúrate de usar una contraseña segura y fácil de recordar</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="update-password-form">
        @csrf
        @method('put')
        
        <div class="row g-4">
            {{-- Contraseña actual --}}
            <div class="col-md-12">
                <div class="form-group-password">
                    <label for="update_password_current_password" class="form-label-password">
                        <i class="bi bi-key me-2"></i>Contraseña actual
                    </label>
                    <div class="input-wrapper-password">
                        <input id="update_password_current_password" 
                               name="current_password" 
                               type="password" 
                               class="password-input @error('current_password', 'updatePassword') is-invalid @enderror" 
                               placeholder="Ingresa tu contraseña actual"
                               autocomplete="current-password">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword(this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback-password">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Nueva contraseña --}}
            <div class="col-md-6">
                <div class="form-group-password">
                    <label for="update_password_password" class="form-label-password">
                        <i class="bi bi-shield-lock me-2"></i>Nueva contraseña
                    </label>
                    <div class="input-wrapper-password">
                        <input id="update_password_password" 
                               name="password" 
                               type="password" 
                               class="password-input @error('password', 'updatePassword') is-invalid @enderror" 
                               placeholder="Ingresa tu nueva contraseña"
                               autocomplete="new-password">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword(this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <div class="password-hint">
                        <i class="bi bi-info-circle me-1"></i>La contraseña debe tener al menos 8 caracteres
                    </div>
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback-password">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Confirmar nueva contraseña --}}
            <div class="col-md-6">
                <div class="form-group-password">
                    <label for="update_password_password_confirmation" class="form-label-password">
                        <i class="bi bi-check-circle me-2"></i>Confirmar nueva contraseña
                    </label>
                    <div class="input-wrapper-password">
                        <input id="update_password_password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               class="password-input" 
                               placeholder="Repite tu nueva contraseña"
                               autocomplete="new-password">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword(this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions-password">
            <button type="submit" class="btn-save-password">
                <i class="bi bi-check-lg me-2"></i>Actualizar contraseña
            </button>
            
            @if (session('status') === 'password-updated')
                <div class="success-message-password">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    ¡Contraseña actualizada correctamente!
                </div>
            @endif
        </div>
    </form>
</section>

<style>
/* ===== PASSWORD FORM STYLES (Coherentes con profile form) ===== */
.update-password-form {
    width: 100%;
}

.form-group-password {
    margin-bottom: 1rem;
}

.form-label-password {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.input-wrapper-password {
    position: relative;
}

.password-input {
    width: 100%;
    padding: 0.85rem 1rem;
    padding-right: 3rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.password-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.password-input.is-invalid {
    border-color: #dc3545;
    background: #fff5f5;
}

.password-toggle-btn {
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

.password-toggle-btn:hover {
    color: #667eea;
}

.password-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

.password-hint i {
    font-size: 0.65rem;
}

.invalid-feedback-password {
    font-size: 0.7rem;
    margin-top: 0.5rem;
    color: #dc3545;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* ===== ACTION BUTTONS ===== */
.form-actions-password {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-save-password {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.75rem;
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

.btn-save-password:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-save-password:active {
    transform: translateY(0);
}

.success-message-password {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    animation: fadeInPassword 0.3s ease;
}

@keyframes fadeInPassword {
    from {
        opacity: 0;
        transform: translateX(10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-actions-password {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-save-password {
        width: 100%;
        justify-content: center;
    }
    
    .success-message-password {
        justify-content: center;
        text-align: center;
    }
}
</style>

<script>
function togglePassword(button) {
    const input = button.parentElement.querySelector('input');
    const icon = button.querySelector('i');
    
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