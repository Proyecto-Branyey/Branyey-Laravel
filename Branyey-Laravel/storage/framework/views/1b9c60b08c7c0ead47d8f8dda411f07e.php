<?php $__env->startSection('title', 'Registro - Branyey'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="text-center mb-4">
                <span class="badge bg-danger mb-2 px-3 py-2" style="background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;">
                    ✨ NUEVO CLIENTE
                </span>
                <h1 class="fw-black display-5 mb-2">Crear Cuenta</h1>
                <p class="text-muted">Completa tus datos para empezar a comprar</p>
            </div>

            
            <div class="register-card">
                <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
                    <?php echo csrf_field(); ?>

                    
                    <div class="register-section">
                        <div class="section-header">
                            <i class="bi bi-person-circle"></i>
                            <h5>Información de cuenta</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-person-badge me-1"></i>Nombre completo
                                    </label>
                                    <input type="text" name="nombre_completo" 
                                           class="register-input <?php $__errorArgs = ['nombre_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('nombre_completo')); ?>" 
                                           placeholder="Ej: Juan Pérez" required autofocus>
                                    <?php $__errorArgs = ['nombre_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-person me-1"></i>Nombre de usuario
                                    </label>
                                    <input type="text" name="username" 
                                           class="register-input <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('username')); ?>" 
                                           placeholder="Ej: juanperez" required>
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-envelope me-1"></i>Correo electrónico
                                    </label>
                                    <input type="email" name="email" 
                                           class="register-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('email')); ?>" 
                                           placeholder="ejemplo@correo.com" required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="register-section">
                        <div class="section-header">
                            <i class="bi bi-truck"></i>
                            <h5>Dirección de envío</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-telephone me-1"></i>Teléfono / WhatsApp
                                    </label>
                                    <input type="tel" name="telefono" id="telefono"
                                           class="register-input <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('telefono')); ?>" 
                                           placeholder="3001234567" required>
                                    <div id="phone-error-register" class="invalid-feedback-register" style="display: none;">
                                        ⚠️ Ingresa un número válido de Colombia (10 dígitos)
                                    </div>
                                    <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-house-door me-1"></i>Dirección
                                    </label>
                                    <input type="text" name="direccion_defecto" 
                                           class="register-input <?php $__errorArgs = ['direccion_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('direccion_defecto')); ?>" 
                                           placeholder="Calle 123 #45-67" required>
                                    <?php $__errorArgs = ['direccion_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-geo-alt me-1"></i>Departamento
                                    </label>
                                    <input type="text" name="departamento_defecto" id="departamento_defecto"
                                           list="departamentos_list" 
                                           class="register-input location-input <?php $__errorArgs = ['departamento_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('departamento_defecto')); ?>" 
                                           placeholder="Selecciona un departamento" required>
                                    <datalist id="departamentos_list"></datalist>
                                    <div id="dept-error-register" class="invalid-feedback-register" style="display: none;">
                                        ⚠️ Por favor selecciona un departamento válido de la lista
                                    </div>
                                    <?php $__errorArgs = ['departamento_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-building me-1"></i>Ciudad
                                    </label>
                                    <input type="text" name="ciudad_defecto" id="ciudad_defecto"
                                           list="ciudades_list" 
                                           class="register-input location-input <?php $__errorArgs = ['ciudad_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('ciudad_defecto')); ?>" 
                                           placeholder="Selecciona una ciudad" required>
                                    <datalist id="ciudades_list"></datalist>
                                    <div id="city-error-register" class="invalid-feedback-register" style="display: none;">
                                        ⚠️ Por favor selecciona una ciudad válida para el departamento seleccionado
                                    </div>
                                    <small class="form-hint-register">
                                        <i class="bi bi-info-circle"></i> Selecciona primero un departamento
                                    </small>
                                    <?php $__errorArgs = ['ciudad_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="register-section">
                        <div class="section-header">
                            <i class="bi bi-shield-lock"></i>
                            <h5>Seguridad</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-key me-1"></i>Contraseña
                                    </label>
                                    <div class="password-wrapper">
                                        <input type="password" name="password" id="password"
                                               class="register-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               placeholder="Mínimo 8 caracteres" required>
                                        <button type="button" class="password-toggle-register" onclick="togglePassword('password')">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                    <small class="form-hint-register">
                                        <i class="bi bi-info-circle"></i> La contraseña debe tener al menos 8 caracteres
                                    </small>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="invalid-feedback-register"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-register">
                                    <label class="form-label-register">
                                        <i class="bi bi-check-circle me-1"></i>Confirmar contraseña
                                    </label>
                                    <div class="password-wrapper">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="register-input" 
                                               placeholder="Repite tu contraseña" required>
                                        <button type="button" class="password-toggle-register" onclick="togglePassword('password_confirmation')">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="register-actions">
                        <button type="submit" class="btn-register" id="registerBtn">
                            <i class="bi bi-person-plus me-2"></i>Registrarme ahora
                        </button>
                    </div>

                    
                    <div class="register-footer">
                        <p>¿Ya tienes cuenta? <a href="<?php echo e(route('login')); ?>">Inicia sesión aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== REGISTER CARD ===== */
.register-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.register-section {
    margin-bottom: 1.75rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.register-section:last-of-type {
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
.form-group-register {
    margin-bottom: 0.25rem;
}

.form-label-register {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.register-input {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.register-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.register-input.is-invalid {
    border-color: #dc3545;
    background: #fff5f5;
}

.invalid-feedback-register {
    font-size: 0.7rem;
    margin-top: 0.5rem;
    color: #dc3545;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.form-hint-register {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== PASSWORD TOGGLE ===== */
.password-wrapper {
    position: relative;
}

.password-toggle-register {
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

.password-toggle-register:hover {
    color: #667eea;
}

/* ===== REGISTER BUTTON ===== */
.register-actions {
    margin-top: 1.5rem;
}

.btn-register {
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

.btn-register:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

/* ===== FOOTER ===== */
.register-footer {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
    font-size: 0.8rem;
}

.register-footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.register-footer a:hover {
    text-decoration: underline;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .register-card {
        padding: 1.5rem;
    }
    
    .register-section {
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
    }
}
</style>

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = input.parentElement.querySelector('.password-toggle-register i');
    
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
    const phoneError = document.getElementById('phone-error-register');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            if (this.value && !validateColombianPhone(this.value)) {
                phoneError.style.display = 'flex';
                this.classList.add('is-invalid');
            } else {
                phoneError.style.display = 'none';
                this.classList.remove('is-invalid');
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
    const deptError = document.getElementById('dept-error-register');
    const cityError = document.getElementById('city-error-register');

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
            }
        } catch (error) {}
    };

    if (deptInput) {
        deptInput.addEventListener('change', async () => {
            cityInput.value = '';
            cityError.style.display = 'none';
            deptError.style.display = 'none';
            if (validDepartments.has(normalize(deptInput.value))) {
                await loadCitiesByDepartmentName();
            } else {
                cityList.innerHTML = '';
                validCitiesForDept.clear();
                deptError.style.display = 'flex';
            }
        });
        
        deptInput.addEventListener('blur', () => {
            if (deptInput.value && !validDepartments.has(normalize(deptInput.value))) {
                deptError.style.display = 'flex';
            } else {
                deptError.style.display = 'none';
            }
        });
    }

    if (cityInput) {
        cityInput.addEventListener('blur', () => {
            if (cityInput.value && !validCitiesForDept.has(normalize(cityInput.value))) {
                cityError.style.display = 'flex';
            } else {
                cityError.style.display = 'none';
            }
        });
    }

    loadDepartments();
});

// Validación final del formulario (CORREGIDA)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const deptInput = document.getElementById('departamento_defecto');
    const cityInput = document.getElementById('ciudad_defecto');
    const phoneInput = document.getElementById('telefono');
    const deptError = document.getElementById('dept-error-register');
    const cityError = document.getElementById('city-error-register');
    const phoneError = document.getElementById('phone-error-register');
    
    // Variables globales para los sets de validación
    window.validDepartmentsSet = new Set();
    window.validCitiesSet = new Set();
    
    // Actualizar los sets cuando el datalist de departamentos esté listo
    const updateValidDepartments = () => {
        const deptList = document.getElementById('departamentos_list');
        if (deptList && deptList.options.length > 0) {
            window.validDepartmentsSet.clear();
            Array.from(deptList.options).forEach(opt => {
                if (opt.value) {
                    window.validDepartmentsSet.add(opt.value.toLowerCase());
                }
            });
        }
    };
    
    // Actualizar los sets cuando el datalist de ciudades esté listo
    const updateValidCities = () => {
        const cityList = document.getElementById('ciudades_list');
        if (cityList && cityList.options.length > 0) {
            window.validCitiesSet.clear();
            Array.from(cityList.options).forEach(opt => {
                if (opt.value) {
                    window.validCitiesSet.add(opt.value.toLowerCase());
                }
            });
        }
    };
    
    // Observar cambios en los datalists
    const deptListObserver = new MutationObserver(updateValidDepartments);
    const cityListObserver = new MutationObserver(updateValidCities);
    
    const deptList = document.getElementById('departamentos_list');
    const cityList = document.getElementById('ciudades_list');
    
    if (deptList) {
        deptListObserver.observe(deptList, { childList: true, subtree: true });
        updateValidDepartments();
    }
    
    if (cityList) {
        cityListObserver.observe(cityList, { childList: true, subtree: true });
        updateValidCities();
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Actualizar sets antes de validar
            updateValidDepartments();
            updateValidCities();
            
            // Validar departamento
            const deptValue = deptInput?.value?.trim();
            if (deptValue && !window.validDepartmentsSet.has(deptValue.toLowerCase())) {
                if (deptError) {
                    deptError.style.display = 'flex';
                    deptError.textContent = '⚠️ Por favor selecciona un departamento válido de la lista';
                }
                isValid = false;
            } else if (deptError) {
                deptError.style.display = 'none';
            }
            
            // Validar ciudad (solo si el departamento es válido)
            const cityValue = cityInput?.value?.trim();
            if (cityValue && !window.validCitiesSet.has(cityValue.toLowerCase())) {
                if (cityError) {
                    cityError.style.display = 'flex';
                    cityError.textContent = '⚠️ Por favor selecciona una ciudad válida para el departamento seleccionado';
                }
                isValid = false;
            } else if (cityError) {
                cityError.style.display = 'none';
            }
            
            // Validar teléfono
            if (phoneInput && phoneInput.value && !validateColombianPhone(phoneInput.value)) {
                if (phoneError) phoneError.style.display = 'flex';
                isValid = false;
            } else if (phoneError) {
                phoneError.style.display = 'none';
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>