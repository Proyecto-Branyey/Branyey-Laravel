<?php $__env->startSection('title', 'Mis Pedidos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4">Mis Pedidos</h2>
    <?php if($ventas->isEmpty()): ?>
        <div class="alert alert-info">No tienes pedidos registrados.</div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Factura</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($venta->id); ?></td>
                    <td><?php echo e($venta->created_at->format('d/m/Y H:i')); ?></td>
                    <td>$<?php echo e(number_format($venta->total, 0, ',', '.')); ?></td>
                    <td><?php echo $venta->estado_badge; ?></td>
                    <td>
                        <a href="<?php echo e(route('tienda.pedidos.factura', $venta->id)); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Ver Factura
                        </a>
                    </td>
                    <td>
                        <?php if($venta->estado === App\Models\Venta::ESTADO_ENVIADO): ?>
                        <form action="<?php echo e(route('tienda.pedidos.recibido', $venta->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success btn-sm">Marcar como recibido</button>
                        </form>
                        <?php elseif($venta->estado === App\Models\Venta::ESTADO_ENTREGADO): ?>
                            <span class="text-success">Recibido</span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/tienda/pedidos.blade.php ENDPATH**/ ?>