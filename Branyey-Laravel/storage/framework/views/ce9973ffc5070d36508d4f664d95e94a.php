<html>
<head>
	<meta charset="utf-8">
	<title>Mis datos de usuario</title>
	<style>
		body { font-family: Arial, sans-serif; }
		h2 { color: #333; }
		.info { margin-bottom: 10px; }
		.label { font-weight: bold; }
	</style>
</head>
<body>
	<h2>Datos de mi cuenta</h2>
	<p>Te recomendamos descargar tu información antes de eliminar tu cuenta.</p>
	<div class="info"><span class="label">Usuario:</span> <?php echo e($user->username); ?></div>
	<div class="info"><span class="label">Correo electrónico:</span> <?php echo e($user->email); ?></div>
	<div class="info"><span class="label">Nombre completo:</span> <?php echo e($user->nombre_completo); ?></div>
	<div class="info"><span class="label">Teléfono:</span> <?php echo e($user->telefono); ?></div>
	<div class="info"><span class="label">Dirección de envío:</span> <?php echo e($user->direccion_defecto); ?></div>
	<div class="info"><span class="label">Ciudad:</span> <?php echo e($user->ciudad_defecto); ?></div>
	<div class="info"><span class="label">Departamento:</span> <?php echo e($user->departamento_defecto); ?></div>
</body>
<hr>
<h2>Historial de compras</h2>
<?php $ventas = $user->ventas; ?>
<?php if($ventas->isEmpty()): ?>
	<p>No tienes compras registradas.</p>
<?php else: ?>
	<table width="100%" border="1" cellspacing="0" cellpadding="4" style="font-size:13px; margin-top:10px;">
		<thead>
			<tr style="background:#f2f2f2;">
				<th>ID</th>
				<th>Fecha</th>
				<th>Total</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
		<?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($venta->id); ?></td>
				<td><?php echo e($venta->created_at->format('Y-m-d')); ?></td>
				<td>$<?php echo e(number_format($venta->total, 2)); ?></td>
				<td><?php echo e(ucfirst($venta->estado)); ?></td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
<?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/profile/datos_pdf.blade.php ENDPATH**/ ?>