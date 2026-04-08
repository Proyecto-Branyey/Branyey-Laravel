<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <h1>Nuevo Usuario</h1>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.usuarios.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre completo</label>
            <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" value="<?php echo e(old('nombre_completo')); ?>">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo e(old('telefono')); ?>">
        </div>
        <div class="mb-3">
            <label for="direccion_defecto" class="form-label">Dirección</label>
            <input type="text" name="direccion_defecto" id="direccion_defecto" class="form-control" value="<?php echo e(old('direccion_defecto')); ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="ciudad_defecto" class="form-label">Ciudad</label>
                <input type="text" name="ciudad_defecto" id="ciudad_defecto" class="form-control" value="<?php echo e(old('ciudad_defecto')); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="departamento_defecto" class="form-label">Departamento</label>
                <input type="text" name="departamento_defecto" id="departamento_defecto" class="form-control" value="<?php echo e(old('departamento_defecto')); ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo e(old('username')); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
        </div>
        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol</label>
            <select name="rol_id" id="rol_id" class="form-control" required>
                <option value="">Seleccione un rol</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($rol->id); ?>" <?php echo e(old('rol_id') == $rol->id ? 'selected' : ''); ?>><?php echo e($rol->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/usuarios/create.blade.php ENDPATH**/ ?>