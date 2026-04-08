<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <h1 class="mb-4">Usuarios</h1>
    <div class="d-flex gap-2 mb-3">
        <a href="<?php echo e(route('admin.usuarios.papelera')); ?>" class="btn btn-outline-danger">Papelera</a>
        <a href="<?php echo e(route('admin.usuarios.create')); ?>" class="btn btn-primary">Nuevo Usuario</a>
    </div>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($usuario->id); ?></td>
                    <td><?php echo e($usuario->nombre_completo); ?></td>
                    <td><?php echo e($usuario->username); ?></td>
                    <td><?php echo e($usuario->email); ?></td>
                    <td><?php echo e($usuario->rol->nombre ?? '-'); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.usuarios.edit', $usuario->id)); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <form action="<?php echo e(route('admin.usuarios.destroy', $usuario->id)); ?>" method="POST" style="display:inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($usuarios->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/usuarios/index.blade.php ENDPATH**/ ?>