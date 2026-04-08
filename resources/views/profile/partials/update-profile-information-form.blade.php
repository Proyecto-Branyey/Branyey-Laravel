<section>
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="bi bi-person-lines-fill me-2"></i>Información de perfil
        </h4>
        <p class="text-muted mb-0">Actualiza tus datos personales y dirección de envío</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" id="profileForm" class="profile-info-form">
        @csrf
        @method('patch')
        
        <div class="row g-4">
            {{-- Usuario --}}
            <div class="col-md-6">
                <div class="form-group-profile">
                    <label for="username" class="form-label-profile">
                        <i class="bi bi-person-badge me-2"></i>Usuario
                    </label>
                    <input id="username" name="username" type="text" 
                           class="profile-input profile-editable" 
                           value="{{ old('username', $user->username) }}" 
                           required autocomplete="username" disabled>
                    @error('username')
                        <div class="invalid-feedback-profile">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Correo electrónico --}}
            <div class="col-md-6">
                <div class="form-group-profile">
                    <label for="email" class="form-label-profile">
                        <i class="bi bi-envelope me-2"></i>Correo electrónico
                    </label>
                    <input id="email" name="email" type="email" 
                           class="profile-input profile-editable" 
                           value="{{ old('email', $user->email) }}" 
                           required autocomplete="email" disabled>
                    @error('email')
                        <div class="invalid-feedback-profile">⚠️ {{ $message }}</div>
                    @enderror
                    
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="verification-warning mt-2">
                            <i class="bi bi-shield-exclamation me-1"></i>
                            Tu correo no está verificado.
                            <button form="send-verification" class="verification-link">Reenviar verificación</button>
                        </div>
                        @if (session('status') === 'verification-link-sent')
                            <div class="verification-success mt-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Se ha enviado un nuevo enlace de verificación a tu correo.
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Nombre completo --}}
            <div class="col-md-6">
                <div class="form-group-profile">
                    <label for="nombre_completo" class="form-label-profile">
                        <i class="bi bi-person-vcard me-2"></i>Nombre completo
                    </label>
                    <input id="nombre_completo" name="nombre_completo" type="text" 
                           class="profile-input profile-editable" 
                           value="{{ old('nombre_completo', $user->nombre_completo) }}" 
                           autocomplete="name" disabled>
                    @error('nombre_completo')
                        <div class="invalid-feedback-profile">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Teléfono con validación Colombia --}}
            <div class="col-md-6">
                <div class="form-group-profile">
                    <label for="telefono" class="form-label-profile">
                        <i class="bi bi-telephone me-2"></i>Teléfono
                    </label>
                    <input id="telefono" name="telefono" type="tel" 
                           class="profile-input profile-editable" 
                           value="{{ old('telefono', $user->telefono) }}" 
                           placeholder="Ej: 3001234567 o 6012345678"
                           autocomplete="tel" disabled>
                    <div id="phone-error" class="invalid-feedback-profile" style="display: none;">
                        ⚠️ Ingresa un número válido de Colombia (10 dígitos)
                    </div>
                    <small class="form-hint">
                        <i class="bi bi-info-circle me-1"></i>Número de 10 dígitos: celular (3xxxxxx) o fijo (6/7xxxxxx)
                    </small>
                    @error('telefono')
                        <div class="invalid-feedback-profile">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Dirección --}}
            <div class="col-12">
                <div class="form-group-profile">
                    <label for="direccion_defecto" class="form-label-profile">
                        <i class="bi bi-house-door me-2"></i>Dirección de envío
                    </label>
                    <input id="direccion_defecto" name="direccion_defecto" type="text" 
                           class="profile-input profile-editable" 
                           value="{{ old('direccion_defecto', $user->direccion_defecto) }}" 
                           placeholder="Calle, número, barrio" disabled>
                    @error('direccion_defecto')
                        <div class="invalid-feedback-profile">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Departamento --}}
            <div class="col-md-6">
                <div class="form-group-profile">
                    <label for="departamento_defecto" class="form-label-profile">
                        <i class="bi bi-geo-alt me-2"></i>Departamento
                    </label>
                    <input type="text" name="departamento_defecto" id="departamento_defecto" 
                           list="departamentos_list" 
                           class="profile-input profile-editable location-input" 
                           value="{{ old('departamento_defecto', $user->departamento_defecto) }}" 
                           autocomplete="off" disabled>
                    <datalist id="departamentos_list"></datalist>
                    <div id="dept-error" class="invalid-feedback-profile" style="display: none;">
                        ⚠️ Por favor selecciona un departamento válido de la lista
                    </div>
                </div>
            </div>

            {{-- Ciudad --}}
            <div class="col-md-6">
                <div class="form-group-profile">
                    <label for="ciudad_defecto" class="form-label-profile">
                        <i class="bi bi-building me-2"></i>Ciudad
                    </label>
                    <input type="text" name="ciudad_defecto" id="ciudad_defecto" 
                           list="ciudades_list" 
                           class="profile-input profile-editable location-input" 
                           value="{{ old('ciudad_defecto', $user->ciudad_defecto) }}" 
                           autocomplete="off" disabled>
                    <datalist id="ciudades_list"></datalist>
                    <div id="city-error" class="invalid-feedback-profile" style="display: none;">
                        ⚠️ Por favor selecciona una ciudad válida para el departamento seleccionado
                    </div>
                    <small class="form-hint">
                        <i class="bi bi-info-circle me-1"></i>Selecciona primero un departamento
                    </small>
                </div>
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="form-actions-profile" id="profile-save-row" style="display: none;">
            <button type="button" class="btn-cancel" onclick="cancelProfileEdit()">
                Cancelar
            </button>
            <button type="submit" class="btn-save-profile" id="saveProfileBtn">
                <i class="bi bi-check-lg me-2"></i>Guardar cambios
            </button>
            @if (session('status') === 'profile-updated')
                <div class="success-message-profile">
                    <i class="bi bi-check-circle-fill me-2"></i>¡Perfil actualizado!
                </div>
            @endif
        </div>
    </form>

    <div class="edit-button-wrapper" id="profile-edit-btn">
        <button type="button" class="btn-edit-profile" onclick="enableProfileEdit()">
            <i class="bi bi-pencil me-2"></i>Editar perfil
        </button>
    </div>
</section>

<style>
/* ===== PROFILE FORM STYLES ===== */
.profile-info-form {
    width: 100%;
}

.form-group-profile {
    margin-bottom: 1rem;
}

.form-label-profile {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.profile-input {
    width: 100%;
    padding: 0.85rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.profile-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.profile-input:disabled {
    background: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
}

.profile-input:not(:disabled):hover {
    border-color: #667eea;
}

.invalid-feedback-profile {
    font-size: 0.7rem;
    margin-top: 0.5rem;
    color: #dc3545;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Verification styles */
.verification-warning {
    background: rgba(255, 193, 7, 0.1);
    padding: 0.5rem 0.75rem;
    border-radius: 12px;
    font-size: 0.7rem;
    color: #ffc107;
}

.verification-link {
    background: none;
    border: none;
    color: #667eea;
    font-weight: 600;
    text-decoration: underline;
    cursor: pointer;
}

.verification-success {
    background: rgba(16, 185, 129, 0.1);
    padding: 0.5rem 0.75rem;
    border-radius: 12px;
    font-size: 0.7rem;
    color: #10b981;
}

.form-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== ACTION BUTTONS ===== */
.form-actions-profile {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-save-profile {
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

.btn-save-profile:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-cancel:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

.btn-edit-profile {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.75rem;
    background: transparent;
    color: #667eea;
    border: 1.5px solid #667eea;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-edit-profile:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.edit-button-wrapper {
    margin-top: 1rem;
    text-align: right;
}

.success-message-profile {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    animation: fadeInProfile 0.3s ease;
}

@keyframes fadeInProfile {
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
    .form-actions-profile {
        flex-direction: column;
    }
    
    .btn-save-profile, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
    
    .edit-button-wrapper {
        text-align: center;
    }
}
</style>

<script>
// Habilitar edición del perfil
function enableProfileEdit() {
    document.querySelectorAll('.profile-editable').forEach(el => el.removeAttribute('disabled'));
    document.getElementById('profile-edit-btn').style.display = 'none';
    document.getElementById('profile-save-row').style.display = 'flex';
}

// Cancelar edición
function cancelProfileEdit() {
    location.reload();
}

// Validar teléfono Colombia (10 dígitos)
function validateColombianPhone(phone) {
    // Limpiar el número (solo dígitos)
    const cleanPhone = phone.toString().replace(/\D/g, '');
    
    // Debe tener exactamente 10 dígitos
    if (cleanPhone.length !== 10) return false;
    
    // Validar primer dígito: 3 para móvil, 6 o 7 para fijo
    const firstDigit = cleanPhone.charAt(0);
    return firstDigit === '3' || firstDigit === '6' || firstDigit === '7';
}

// Validación de ubicación y teléfono antes de enviar
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('profileForm');
    const deptInput = document.getElementById('departamento_defecto');
    const cityInput = document.getElementById('ciudad_defecto');
    const phoneInput = document.getElementById('telefono');
    const deptList = document.getElementById('departamentos_list');
    const cityList = document.getElementById('ciudades_list');
    const deptError = document.getElementById('dept-error');
    const cityError = document.getElementById('city-error');
    const phoneError = document.getElementById('phone-error');

    const API_BASE = 'https://api-colombia.com/api/v1';
    let departments = [];
    let validDepartments = new Set();
    let validCitiesForDept = new Set();
    let currentDepartmentId = null;

    const normalize = (value) => (value || '').toString().trim().toLowerCase();

    // Validar teléfono en tiempo real
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            const cleanPhone = this.value.replace(/\D/g, '');
            if (this.value && !validateColombianPhone(this.value)) {
                phoneError.style.display = 'flex';
            } else {
                phoneError.style.display = 'none';
            }
        });
    }

    // Validar antes de enviar
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const deptValue = normalize(deptInput.value);
            const cityValue = normalize(cityInput.value);
            
            // Validar departamento
            if (deptInput.value && !validDepartments.has(deptValue)) {
                deptError.style.display = 'flex';
                isValid = false;
            } else {
                deptError.style.display = 'none';
            }
            
            // Validar ciudad
            if (cityInput.value && !validCitiesForDept.has(cityValue)) {
                cityError.style.display = 'flex';
                isValid = false;
            } else {
                cityError.style.display = 'none';
            }
            
            // Validar teléfono
            if (phoneInput && phoneInput.value && !validateColombianPhone(phoneInput.value)) {
                phoneError.style.display = 'flex';
                isValid = false;
            } else if (phoneError) {
                phoneError.style.display = 'none';
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    const renderCityOptions = (cities) => {
        cityList.innerHTML = '';
        validCitiesForDept.clear();
        if (Array.isArray(cities)) {
            cities.forEach((city) => {
                const option = document.createElement('option');
                option.value = city.name;
                cityList.appendChild(option);
                validCitiesForDept.add(normalize(city.name));
            });
        }
    };

    const loadCitiesByDepartmentName = async () => {
        const deptName = normalize(deptInput.value);
        const selectedDepartment = departments.find((dept) => normalize(dept.name) === deptName);

        cityList.innerHTML = '';
        validCitiesForDept.clear();

        if (!selectedDepartment) {
            return;
        }

        currentDepartmentId = selectedDepartment.id;

        try {
            const response = await fetch(`${API_BASE}/Department/${selectedDepartment.id}/cities`);
            if (!response.ok) return;
            const cities = await response.json();
            renderCityOptions(Array.isArray(cities) ? cities : []);
            
            // Restaurar el valor de ciudad si ya estaba guardado
            const savedCity = "{{ old('ciudad_defecto', $user->ciudad_defecto) }}";
            if (savedCity && cityInput) {
                cityInput.value = savedCity;
            }
        } catch (error) {
            console.error('Error loading cities:', error);
        }
    };

    const loadDepartments = async () => {
        try {
            const response = await fetch(`${API_BASE}/Department`);
            if (!response.ok) return;

            const data = await response.json();
            departments = Array.isArray(data)
                ? data.slice().sort((a, b) => a.name.localeCompare(b.name, 'es'))
                : [];

            deptList.innerHTML = '';
            validDepartments.clear();
            
            departments.forEach((dept) => {
                const option = document.createElement('option');
                option.value = dept.name;
                deptList.appendChild(option);
                validDepartments.add(normalize(dept.name));
            });

            // Si hay un departamento guardado, cargar sus ciudades
            const savedDept = "{{ old('departamento_defecto', $user->departamento_defecto) }}";
            if (savedDept && deptInput) {
                deptInput.value = savedDept;
                if (validDepartments.has(normalize(savedDept))) {
                    await loadCitiesByDepartmentName();
                }
            }
        } catch (error) {
            console.error('Error loading departments:', error);
        }
    };

    if (deptInput) {
        deptInput.addEventListener('change', async () => {
            cityError.style.display = 'none';
            deptError.style.display = 'none';
            if (validDepartments.has(normalize(deptInput.value))) {
                await loadCitiesByDepartmentName();
            } else {
                cityList.innerHTML = '';
                validCitiesForDept.clear();
                if (cityInput) cityInput.value = '';
            }
        });
        deptInput.addEventListener('blur', () => {
            if (deptInput.value && !validDepartments.has(normalize(deptInput.value))) {
                deptError.style.display = 'flex';
            }
        });
    }

    loadDepartments();
});
</script>