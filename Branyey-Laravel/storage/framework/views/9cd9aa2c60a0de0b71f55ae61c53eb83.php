<?php $__env->startSection('title', 'Mi Carrito'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="fw-black text-uppercase italic mb-5">Tu Carrito</h1>

    <?php if(count($cart) > 0): ?>
        <div class="table-responsive shadow-sm rounded-4 bg-white p-4">
            <table class="table align-middle">
                <thead class="text-uppercase small fw-bold text-muted">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php
                                        $img = $details['image'] ?? 'default.jpg';
                                        $imgUrl = Str::startsWith($img, ['http', 'storage/', '/storage/']) ? asset($img) : Storage::url($img);
                                    ?>
                                    <img src="<?php echo e($imgUrl); ?>" width="60" class="rounded-3 me-3">
                                    <div>
                                        <p class="mb-0 fw-bold"><?php echo e($details['name']); ?></p>
                                        <small class="text-muted">TALLA: <?php echo e($details['talla']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>$<?php echo e(number_format($details['price'], 0, ',', '.')); ?> COP</td>
                            <td style="width: 150px;">
                                <form action="<?php echo e(route('tienda.cart.update', $id)); ?>" method="POST" class="d-flex align-items-center">
                                    <?php echo csrf_field(); ?>
                                    <input type="number" name="quantity" value="<?php echo e($details['quantity']); ?>" min="1" class="form-control form-control-sm me-2">
                                    <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-arrow-clockwise"></i></button>
                                </form>
                            </td>
                            <td class="fw-bold">$<?php echo e(number_format($details['price'] * $details['quantity'], 0, ',', '.')); ?> COP</td>
                            <td class="text-end">
                                <form action="<?php echo e(route('tienda.cart.remove', $id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            
            <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
                <a href="<?php echo e(route('tienda.catalogo')); ?>" class="btn btn-outline-dark rounded-pill px-4">
                    Seguir Comprando
                </a>
                <div class="text-end">
                    <p class="text-muted mb-0 small">Total a pagar:</p>
                    <h3 class="fw-black mb-3">$<?php echo e(number_format($total, 0, ',', '.')); ?> COP</h3>
                    <a href="<?php echo e(route('tienda.checkout')); ?>" class="btn btn-dark btn-lg rounded-pill px-5 text-uppercase fw-black shadow-lg">
                        Finalizar Compra
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5 shadow-sm rounded-4 bg-white">
            <h2 class="fw-bold">Tu carrito está vacío</h2>
            <a href="<?php echo e(route('tienda.catalogo')); ?>" class="btn btn-dark mt-3 rounded-pill px-5">Ir al Catálogo</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/tienda/carrito/index.blade.php ENDPATH**/ ?>