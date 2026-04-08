<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <h1>Editar Usuario</h1>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.usuarios.update', $usuario->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre completo</label>
            <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" value="<?php echo e(old('nombre_completo', $usuario->nombre_completo)); ?>">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo e(old('telefono', $usuario->telefono)); ?>">
        </div>
        <div class="mb-3">
            <label for="direccion_defecto" class="form-label">Dirección</label>
            <input type="text" name="direccion_defecto" id="direccion_defecto" class="form-control" value="<?php echo e(old('direccion_defecto', $usuario->direccion_defecto)); ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="departamento_defecto" class="form-label">Departamento</label>
                <input type="text" name="departamento_defecto" id="departamento_defecto" list="departamentos_list" class="form-control" value="<?php echo e(old('departamento_defecto', $usuario->departamento_defecto)); ?>">
                <datalist id="departamentos_list"></datalist>
            </div>
            <div class="col-md-6 mb-3">
                <label for="ciudad_defecto" class="form-label">Ciudad</label>
                <input type="text" name="ciudad_defecto" id="ciudad_defecto" list="ciudades_list" class="form-control" value="<?php echo e(old('ciudad_defecto', $usuario->ciudad_defecto)); ?>">
                <datalist id="ciudades_list"></datalist>
                <small class="text-muted">Selecciona primero un departamento para sugerir municipios.</small>
            </div>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo e(old('username', $usuario->username)); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email', $usuario->email)); ?>" required>
        </div>
        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol</label>
            <select name="rol_id" id="rol_id" class="form-control" required>
                <option value="">Seleccione un rol</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($rol->id); ?>" <?php echo e(old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : ''); ?>><?php echo e($rol->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/usuarios/edit.blade.php ENDPATH**/ ?>