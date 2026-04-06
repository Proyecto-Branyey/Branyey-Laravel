<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas (PDF)</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo de cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($venta->id); ?></td>
                    <td><?php echo e($venta->usuario->nombre_completo ?? $venta->usuario->name ?? '-'); ?></td>
                    <td><?php echo e($venta->usuario->rol->nombre ?? '-'); ?></td>
                    <td><?php echo e($venta->created_at->format('Y-m-d H:i')); ?></td>
                    <td>$<?php echo e(number_format($venta->total, 0, ',', '.')); ?></td>
                    <td><?php echo e(ucfirst($venta->estado)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/ventas/reporte_pdf.blade.php ENDPATH**/ ?>