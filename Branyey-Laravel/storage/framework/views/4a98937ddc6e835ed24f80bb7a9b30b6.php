<?php $__env->startSection('title', 'Registro Completo - Branyey'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark">CREAR CUENTA</h2>
                        <p class="text-muted small">Completa tus datos para agilizar tus envíos y compras.</p>
                    </div>

                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>

                        <h5 class="text-secondary border-bottom pb-2 mb-3">Información de Cuenta</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">NOMBRE COMPLETO</label>
                                <input type="text" name="nombre_completo" class="form-control <?php $__errorArgs = ['nombre_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nombre_completo')); ?>" required autofocus>
                                <?php $__errorArgs = ['nombre_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">NOMBRE DE USUARIO</label>
                                <input type="text" name="username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('username')); ?>" required>
                                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small fw-bold">CORREO ELECTRÓNICO</label>
                                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-3">Datos de Envío y Contacto</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">TELÉFONO / WHATSAPP</label>
                                <input type="text" name="telefono" class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('telefono')); ?>" required placeholder="300 000 0000">
                                <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">DIRECCIÓN</label>
                                <input type="text" name="direccion_defecto" class="form-control <?php $__errorArgs = ['direccion_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('direccion_defecto')); ?>" required placeholder="Calle, Carrera, Apto...">
                                <?php $__errorArgs = ['direccion_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">DEPARTAMENTO</label>
                                <input type="text" name="departamento_defecto" id="departamento_defecto" list="departamentos_list" class="form-control <?php $__errorArgs = ['departamento_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('departamento_defecto')); ?>" required>
                                <datalist id="departamentos_list"></datalist>
                                <?php $__errorArgs = ['departamento_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">CIUDAD</label>
                                <input type="text" name="ciudad_defecto" id="ciudad_defecto" list="ciudades_list" class="form-control <?php $__errorArgs = ['ciudad_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('ciudad_defecto')); ?>" required>
                                <datalist id="ciudades_list"></datalist>
                                <small class="text-muted">Selecciona primero un departamento para sugerir municipios.</small>
                                <?php $__errorArgs = ['ciudad_defecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-3">Seguridad</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">CONTRASEÑA</label>
                                <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">CONFIRMAR CONTRASEÑA</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark py-3 fw-bold">REGISTRARME AHORA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deptInput = document.getElementById('departamento_defecto');
    const cityInput = document.getElementById('ciudad_defecto');
    const deptList = document.getElementById('departamentos_list');
    const cityList = document.getElementById('ciudades_list');

    if (!deptInput || !cityInput || !deptList || !cityList) {
        return;
    }

    const API_BASE = 'https://api-colombia.com/api/v1';
    let departments = [];

    const normalize = (value) => (value || '').toString().trim().toLowerCase();

    const renderCityOptions = (cities) => {
        cityList.innerHTML = '';
        cities.forEach((city) => {
            const option = document.createElement('option');
            option.value = city.name;
            cityList.appendChild(option);
        });
    };

    const loadCitiesByDepartmentName = async () => {
        const deptName = normalize(deptInput.value);
        const selectedDepartment = departments.find((dept) => normalize(dept.name) === deptName);

        cityList.innerHTML = '';

        if (!selectedDepartment) {
            return;
        }

        try {
            const response = await fetch(`${API_BASE}/Department/${selectedDepartment.id}/cities`);
            if (!response.ok) {
                return;
            }
            const cities = await response.json();
            renderCityOptions(Array.isArray(cities) ? cities : []);
        } catch (error) {
            // Si la API falla, el usuario puede escribir ciudad manualmente.
        }
    };

    const loadDepartments = async () => {
        try {
            const response = await fetch(`${API_BASE}/Department`);
            if (!response.ok) {
                return;
            }

            const data = await response.json();
            departments = Array.isArray(data)
                ? data.slice().sort((a, b) => a.name.localeCompare(b.name, 'es'))
                : [];

            deptList.innerHTML = '';
            departments.forEach((dept) => {
                const option = document.createElement('option');
                option.value = dept.name;
                deptList.appendChild(option);
            });

            if (deptInput.value) {
                loadCitiesByDepartmentName();
            }
        } catch (error) {
            // Si la API falla, el usuario puede escribir departamento manualmente.
        }
    };

    deptInput.addEventListener('change', () => {
        cityInput.value = '';
        loadCitiesByDepartmentName();
    });

    deptInput.addEventListener('blur', loadCitiesByDepartmentName);

    loadDepartments();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/auth/register.blade.php ENDPATH**/ ?>