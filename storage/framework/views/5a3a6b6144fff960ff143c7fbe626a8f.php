<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta #<?php echo e($venta->id); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .header { margin-bottom: 20px; }
        .datos { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .total { font-weight: bold; font-size: 1.1em; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Factura de Venta #<?php echo e($venta->id); ?></h2>
        <div class="datos">
            <strong>Cliente:</strong> <?php echo e($venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-'); ?><br>
            <strong>Email:</strong> <?php echo e($venta->usuario->email ?? '-'); ?><br>
            <strong>Teléfono:</strong> <?php echo e($venta->usuario->telefono ?? '-'); ?><br>
            <strong>Fecha:</strong> <?php echo e($venta->created_at->format('Y-m-d H:i')); ?><br>
            <strong>Estado:</strong> <?php echo e(ucfirst($venta->estado)); ?><br>
            <?php if($venta->detallesOrden): ?>
                <strong>Dirección de envío:</strong> <?php echo e($venta->detallesOrden->direccion ?? '-'); ?><br>
                <strong>Ciudad:</strong> <?php echo e($venta->detallesOrden->ciudad ?? '-'); ?><br>
            <?php endif; ?>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $venta->detallesVenta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($detalle->variante && $detalle->variante->producto ? $detalle->variante->producto->nombre_comercial ?? $detalle->variante->producto->nombre ?? '-' : '-'); ?></td>
                    <td><?php echo e($detalle->cantidad); ?></td>
                    <td>$<?php echo e(number_format($detalle->precio_cobrado, 0, ',', '.')); ?></td>
                    <td>$<?php echo e(number_format($detalle->cantidad * $detalle->precio_cobrado, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">TOTAL</td>
                <td class="total">$<?php echo e(number_format($venta->total, 0, ',', '.')); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
<?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/ventas/factura.blade.php ENDPATH**/ ?>