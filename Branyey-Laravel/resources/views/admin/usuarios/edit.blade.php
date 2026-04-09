@extends('layouts.admin')

@section('admin-content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-pencil-square me-2"></i>Editar Usuario
            </h1>
            <p class="text-muted small mb-0">Actualiza la información del usuario #{{ $usuario->id }}</p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <div class="form-card">
        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" id="userForm">
            @csrf
            @method('PUT')

            {{-- Sección 1: Información personal --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-person-badge"></i>
                    <h5>Información personal</h5>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-person-vcard me-1"></i>Nombre completo
                            </label>
                            <input type="text" name="nombre_completo" 
                                   class="form-input @error('nombre_completo') is-invalid @enderror" 
                                   value="{{ old('nombre_completo', $usuario->nombre_completo) }}" 
                                   placeholder="Ej: Juan Pérez">
                            @error('nombre_completo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-telephone me-1"></i>Teléfono / WhatsApp
                            </label>
                            <input type="tel" name="telefono" id="telefono"
                                   class="form-input @error('telefono') is-invalid @enderror" 
                                   value="{{ old('telefono', $usuario->telefono) }}" 
                                   placeholder="3001234567">
                            <div id="phone-error" class="invalid-feedback" style="display: none;">
                                ⚠️ Ingresa un número válido de Colombia (10 dígitos)
                            </div>
                            <small class="form-hint">Celular (3xxxx) o fijo (6/7xxxx) - 10 dígitos</small>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-house-door me-1"></i>Dirección
                            </label>
                            <input type="text" name="direccion_defecto" 
                                   class="form-input @error('direccion_defecto') is-invalid @enderror" 
                                   value="{{ old('direccion_defecto', $usuario->direccion_defecto) }}" 
                                   placeholder="Calle 123 #45-67, Apto 101">
                            @error('direccion_defecto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Departamento <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="departamento_defecto" id="departamento_defecto"
                                list="departamentos_list" 
                                class="form-input location-input @error('departamento_defecto') is-invalid @enderror" 
                                value="{{ old('departamento_defecto', $usuario->departamento_defecto) }}" 
                                placeholder="Selecciona un departamento" required>
                            <datalist id="departamentos_list"></datalist>
                            <div id="dept-error" class="invalid-feedback" style="display: none;">
                                ⚠️ Por favor selecciona un departamento válido de la lista
                            </div>
                            @error('departamento_defecto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-building me-1"></i>Ciudad <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ciudad_defecto" id="ciudad_defecto"
                                list="ciudades_list" 
                                class="form-input location-input @error('ciudad_defecto') is-invalid @enderror" 
                                value="{{ old('ciudad_defecto', $usuario->ciudad_defecto) }}" 
                                placeholder="Selecciona una ciudad" required>
                            <datalist id="ciudades_list"></datalist>
                            <div id="city-error" class="invalid-feedback" style="display: none;">
                                ⚠️ Por favor selecciona una ciudad válida para el departamento seleccionado
                            </div>
                            <small class="form-hint">Selecciona primero un departamento</small>
                            @error('ciudad_defecto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección 2: Credenciales de acceso --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-shield-lock"></i>
                    <h5>Credenciales de acceso</h5>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-person me-1"></i>Nombre de usuario
                            </label>
                            <input type="text" name="username" 
                                   class="form-input @error('username') is-invalid @enderror" 
                                   value="{{ old('username', $usuario->username) }}" 
                                   placeholder="Ej: juanperez" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-envelope me-1"></i>Correo electrónico
                            </label>
                            <input type="email" name="email" 
                                   class="form-input @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $usuario->email) }}" 
                                   placeholder="ejemplo@correo.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-key me-1"></i>Nueva contraseña
                            </label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password"
                                    class="form-input @error('password') is-invalid @enderror" 
                                    placeholder="Dejar en blanco para no cambiar">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <small class="form-hint">Mínimo 8 caracteres. Dejar en blanco para mantener la actual</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-check-circle me-1"></i>Confirmar contraseña
                            </label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-input" placeholder="Repite la nueva contraseña">
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-person-badge me-1"></i>Rol
                            </label>
                            <select name="rol_id" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
                                        {{ ucfirst($rol->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rol_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="form-actions">
                <button type="submit" class="btn-save" id="submitBtn">
                    <i class="bi bi-check-lg me-2"></i>Actualizar usuario
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn-cancel">
                    <i class="bi bi-x-lg me-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* ===== FORM CARD ===== */
.form-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
}

.section-header i {
    font-size: 1.2rem;
    color: #667eea;
}

.section-header h5 {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin: 0;
}

/* ===== FORM GROUPS ===== */
.form-group {
    margin-bottom: 0.25rem;
}

.form-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.form-input, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input.is-invalid {
    border-color: #dc3545;
    background: #fff5f5;
}

.invalid-feedback {
    font-size: 0.7rem;
    margin-top: 0.5rem;
    color: #dc3545;
    display: block;
}

.form-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== PASSWORD TOGGLE ===== */
.password-wrapper {
    position: relative;
}

.password-toggle {
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

.password-toggle:hover {
    color: #667eea;
}

/* ===== ALERTAS ===== */
.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    border-left: 3px solid #dc3545;
}

.alert-error-card ul {
    padding-left: 1.5rem;
    margin: 0;
}

/* ===== BOTONES ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
}

.btn-save {
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

.btn-save:hover {
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
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

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

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-card {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-save, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = input.parentElement.querySelector('.password-toggle i');
    
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

// Validar teléfono Colombia
function validateColombianPhone(phone) {
    const cleanPhone = phone.toString().replace(/\D/g, '');
    if (cleanPhone.length !== 10) return false;
    const firstDigit = cleanPhone.charAt(0);
    return firstDigit === '3' || firstDigit === '6' || firstDigit === '7';
}

// Validación en tiempo real del teléfono
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('telefono');
    const phoneError = document.getElementById('phone-error');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            if (this.value && !validateColombianPhone(this.value)) {
                phoneError.style.display = 'block';
                this.classList.add('is-invalid');
            } else {
                phoneError.style.display = 'none';
                this.classList.remove('is-invalid');
            }
        });
        
        phoneInput.addEventListener('blur', function() {
            if (this.value && !validateColombianPhone(this.value)) {
                phoneError.style.display = 'block';
                this.classList.add('is-invalid');
            }
        });
    }
});

// API Colombia para departamentos y ciudades
document.addEventListener('DOMContentLoaded', function () {
    const deptInput = document.getElementById('departamento_defecto');
    const cityInput = document.getElementById('ciudad_defecto');
    const deptList = document.getElementById('departamentos_list');
    const cityList = document.getElementById('ciudades_list');
    const deptError = document.getElementById('dept-error');
    const cityError = document.getElementById('city-error');

    if (!deptInput || !cityInput || !deptList || !cityList) return;

    const API_BASE = 'https://api-colombia.com/api/v1';
    let departments = [];
    let validDepartments = new Set();
    let validCitiesForDept = new Set();

    const normalize = (value) => (value || '').toString().trim().toLowerCase();

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
        cityError.style.display = 'none';

        if (!selectedDepartment) return;

        try {
            const response = await fetch(`${API_BASE}/Department/${selectedDepartment.id}/cities`);
            if (!response.ok) return;
            const cities = await response.json();
            renderCityOptions(Array.isArray(cities) ? cities : []);
        } catch (error) {}
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

            if (deptInput.value && validDepartments.has(normalize(deptInput.value))) {
                await loadCitiesByDepartmentName();
                // Restaurar ciudad si existe
                const savedCity = "{{ old('ciudad_defecto', $usuario->ciudad_defecto ?? '') }}";
                if (savedCity && cityInput) {
                    cityInput.value = savedCity;
                }
            }
        } catch (error) {}
    };

    // Validación en tiempo real para departamento
    if (deptInput) {
        deptInput.addEventListener('change', async () => {
            cityInput.value = '';
            cityError.style.display = 'none';
            deptError.style.display = 'none';
            deptInput.classList.remove('is-invalid');
            
            if (!deptInput.value || deptInput.value.trim() === '') {
                deptError.textContent = '⚠️ El departamento es obligatorio';
                deptError.style.display = 'block';
                deptInput.classList.add('is-invalid');
            } else if (validDepartments.has(normalize(deptInput.value))) {
                await loadCitiesByDepartmentName();
            } else {
                cityList.innerHTML = '';
                validCitiesForDept.clear();
                deptError.textContent = '⚠️ Por favor selecciona un departamento válido de la lista';
                deptError.style.display = 'block';
                deptInput.classList.add('is-invalid');
            }
        });
        
        deptInput.addEventListener('input', function() {
            if (this.value && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                if (deptError) deptError.style.display = 'none';
            } else {
                this.classList.add('is-invalid');
                if (deptError) {
                    deptError.textContent = '⚠️ El departamento es obligatorio';
                    deptError.style.display = 'block';
                }
            }
        });
        
        deptInput.addEventListener('blur', function() {
            if (!this.value || this.value.trim() === '') {
                this.classList.add('is-invalid');
                if (deptError) {
                    deptError.textContent = '⚠️ El departamento es obligatorio';
                    deptError.style.display = 'block';
                }
            } else if (!validDepartments.has(normalize(this.value))) {
                this.classList.add('is-invalid');
                if (deptError) {
                    deptError.textContent = '⚠️ Por favor selecciona un departamento válido de la lista';
                    deptError.style.display = 'block';
                }
            } else {
                this.classList.remove('is-invalid');
                if (deptError) deptError.style.display = 'none';
            }
        });
    }

    // Validación en tiempo real para ciudad
    if (cityInput) {
        cityInput.addEventListener('input', function() {
            if (this.value && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                if (cityError) cityError.style.display = 'none';
            } else {
                this.classList.add('is-invalid');
                if (cityError) {
                    cityError.textContent = '⚠️ La ciudad es obligatoria';
                    cityError.style.display = 'block';
                }
            }
        });
        
        cityInput.addEventListener('blur', function() {
            if (!this.value || this.value.trim() === '') {
                this.classList.add('is-invalid');
                if (cityError) {
                    cityError.textContent = '⚠️ La ciudad es obligatoria';
                    cityError.style.display = 'block';
                }
            } else if (!validCitiesForDept.has(normalize(this.value))) {
                this.classList.add('is-invalid');
                if (cityError) {
                    cityError.textContent = '⚠️ Por favor selecciona una ciudad válida para el departamento seleccionado';
                    cityError.style.display = 'block';
                }
            } else {
                this.classList.remove('is-invalid');
                if (cityError) cityError.style.display = 'none';
            }
        });
    }

    loadDepartments();
});

// Validación final del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const deptInput = document.getElementById('departamento_defecto');
    const cityInput = document.getElementById('ciudad_defecto');
    const phoneInput = document.getElementById('telefono');
    const deptError = document.getElementById('dept-error');
    const cityError = document.getElementById('city-error');
    const phoneError = document.getElementById('phone-error');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validar que departamento no esté vacío
            if (!deptInput.value || deptInput.value.trim() === '') {
                if (deptError) {
                    deptError.textContent = '⚠️ El departamento es obligatorio';
                    deptError.style.display = 'block';
                }
                deptInput.classList.add('is-invalid');
                isValid = false;
            } else {
                // Validar departamento contra la API
                const deptList = document.getElementById('departamentos_list');
                const validDepartments = new Set();
                Array.from(deptList.options).forEach(opt => {
                    if (opt.value) validDepartments.add(opt.value.toLowerCase());
                });
                
                if (!validDepartments.has(deptInput.value.toLowerCase())) {
                    if (deptError) {
                        deptError.textContent = '⚠️ Por favor selecciona un departamento válido de la lista';
                        deptError.style.display = 'block';
                    }
                    deptInput.classList.add('is-invalid');
                    isValid = false;
                } else if (deptError) {
                    deptError.style.display = 'none';
                    deptInput.classList.remove('is-invalid');
                }
            }
            
            // Validar que ciudad no esté vacía
            if (!cityInput.value || cityInput.value.trim() === '') {
                if (cityError) {
                    cityError.textContent = '⚠️ La ciudad es obligatoria';
                    cityError.style.display = 'block';
                }
                cityInput.classList.add('is-invalid');
                isValid = false;
            } else {
                // Validar ciudad contra la API
                const cityList = document.getElementById('ciudades_list');
                const validCities = new Set();
                Array.from(cityList.options).forEach(opt => {
                    if (opt.value) validCities.add(opt.value.toLowerCase());
                });
                
                if (!validCities.has(cityInput.value.toLowerCase())) {
                    if (cityError) {
                        cityError.textContent = '⚠️ Por favor selecciona una ciudad válida para el departamento seleccionado';
                        cityError.style.display = 'block';
                    }
                    cityInput.classList.add('is-invalid');
                    isValid = false;
                } else if (cityError) {
                    cityError.style.display = 'none';
                    cityInput.classList.remove('is-invalid');
                }
            }
            
            // Validar teléfono (solo si tiene valor)
            if (phoneInput && phoneInput.value && !validateColombianPhone(phoneInput.value)) {
                if (phoneError) {
                    phoneError.textContent = '⚠️ Ingresa un número válido de Colombia (10 dígitos)';
                    phoneError.style.display = 'block';
                }
                phoneInput.classList.add('is-invalid');
                isValid = false;
            } else if (phoneError) {
                phoneError.style.display = 'none';
                phoneInput?.classList.remove('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection