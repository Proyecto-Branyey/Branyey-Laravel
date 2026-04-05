<?php $__env->startSection('title', $producto->nombre . ' - Branyey'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white min-h-screen py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb small text-uppercase fw-black italic tracking-widest mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-muted text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('tienda.catalogo')); ?>" class="text-muted text-decoration-none">Catálogo</a></li>
                <li class="breadcrumb-item active text-dark"><?php echo e($producto->nombre); ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="sticky-top" style="top: 100px;">
                    <?php $primeraImg = $producto->imagenes->first(); ?>
                    <div class="rounded-5 overflow-hidden shadow-sm bg-light mb-3">
                        <img id="main-product-image" 
                             src="<?php echo e($primeraImg ? Storage::url($primeraImg->ruta) : asset('img/placeholder.jpg')); ?>" 
                             class="img-fluid w-100 object-cover" style="min-height: 550px; object-position: top;">
                    </div>

                    <div class="d-flex gap-2 overflow-auto pb-2" id="gallery-thumbs">
                        <?php $colorIndex = 0; ?>
                        <?php $__currentLoopData = $producto->variantes->flatMap->colores->unique('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $imagenColor = $producto->imagenes->skip($colorIndex)->first();
                                $colorIndex++;
                            ?>
                            <?php if($imagenColor): ?>
                                <img src="<?php echo e(Storage::url($imagenColor->ruta)); ?>" class="rounded-4 thumb-img border cursor-pointer"
                                     style="width: 80px; height: 100px; object-fit: cover;"
                                     data-full="<?php echo e(Storage::url($imagenColor->ruta)); ?>"
                                     data-color-id="<?php echo e($color->id); ?>"
                                     onclick="document.getElementById('main-product-image').src = this.dataset.full">
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ps-lg-4">
                    <span class="badge bg-dark rounded-pill px-3 py-2 mb-3 text-uppercase tracking-widest" style="font-size: 10px;">
                        <?php echo e($producto->estilo->nombre ?? 'Colección'); ?> • Colección 2026
                    </span>

                    <h1 class="display-4 fw-black text-uppercase italic tracking-tighter mb-2"><?php echo e($producto->nombre); ?></h1>
                    <p class="text-muted fw-bold mb-4 small tracking-widest">REF: <?php echo e($producto->estilo->nombre ?? ''); ?></p>

                    <h2 class="fw-bold mb-5 display-6 text-dark">
                        <span id="price-display">Selecciona color y talla</span>
                    </h2>

                    <form action="<?php echo e(route('tienda.cart.add')); ?>" method="POST" id="form-compra">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="producto_id" value="<?php echo e($producto->id); ?>">

                        <div class="mb-5">
                            <label class="form-label fw-black text-uppercase small tracking-widest mb-3">1. Elige Color</label>
                            <div class="d-flex flex-wrap gap-3">
                                <?php $__currentLoopData = $producto->variantes->flatMap->colores->unique('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="color-option">
                                        <input type="radio" name="color_id" id="c-<?php echo e($color->id); ?>" value="<?php echo e($color->id); ?>" 
                                               class="btn-check color-radio" data-color-id="<?php echo e($color->id); ?>" required>
                                        <label class="color-circle shadow-sm" for="c-<?php echo e($color->id); ?>" 
                                               style="background-color: <?php echo e($color->codigo_hex); ?>; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; border: 3px solid #fff; display: block;">
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-black text-uppercase small tracking-widest mb-3">2. Elige Talla</label>
                            <div class="d-flex flex-wrap gap-2" id="tallas-container">
                                <?php $__currentLoopData = $producto->variantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $v->colores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="talla-item d-none color-group-<?php echo e($color->id); ?>">
                                            <input type="radio" name="variante_id" id="v-<?php echo e($v->id); ?>" value="<?php echo e($v->id); ?>" 
                                                   class="btn-check talla-radio" data-precio="<?php echo e($v->precio_formateado); ?>" 
                                                   data-stock="<?php echo e($v->stock); ?>" required>
                                            <label class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold" for="v-<?php echo e($v->id); ?>">
                                                <?php echo e($v->talla->nombre); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-3">
                                <input type="number" name="quantity" value="1" min="1" class="form-control form-control-lg rounded-pill text-center fw-bold border-dark">
                            </div>
                            <div class="col-9">
                                <button type="submit" id="btn-add" class="btn btn-dark btn-lg rounded-pill w-100 py-3 fw-black text-uppercase tracking-widest shadow-lg" disabled>
                                    Añadir al Carrito
                                </button>
                            </div>
                        </div>
                        <p id="stock-warning" class="text-danger small mt-3 d-none fw-bold text-center text-uppercase">Agotado en esta combinación</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorRadios = document.querySelectorAll('.color-radio');
    const tallaRadios = document.querySelectorAll('.talla-radio');
    const btnAdd = document.getElementById('btn-add');
    const priceDisplay = document.getElementById('price-display');

    colorRadios.forEach(radio => {
        radio.addEventListener('click', function() {
            const colorId = this.dataset.colorId;
            document.querySelectorAll('.talla-item').forEach(el => el.classList.add('d-none'));
            document.querySelectorAll('.color-group-' + colorId).forEach(el => el.classList.remove('d-none'));
            tallaRadios.forEach(r => r.checked = false);
            btnAdd.disabled = true;
            priceDisplay.innerText = "Ahora elige una talla";

            // Cambiar imagen principal al color seleccionado
            const colorThumb = document.querySelector('.thumb-img[data-color-id="'+colorId+'"]');
            if(colorThumb) {
                document.getElementById('main-product-image').src = colorThumb.dataset.full;
            }
        });
    });

    tallaRadios.forEach(radio => {
        radio.addEventListener('click', function() {
            const stock = parseInt(this.dataset.stock);
            priceDisplay.innerText = this.dataset.precio;

            if (stock > 0) {
                btnAdd.disabled = false;
                document.getElementById('stock-warning').classList.add('d-none');
            } else {
                btnAdd.disabled = true;
                document.getElementById('stock-warning').classList.remove('d-none');
            }
        });
    });
});
</script>

<style>
    .fw-black { font-weight: 900; }
    .italic { font-style: italic; }
    .tracking-tighter { letter-spacing: -2px; }
    .tracking-widest { letter-spacing: 2px; }
    .rounded-5 { border-radius: 2rem !important; }
    .color-radio:checked + .color-circle { border-color: #000 !important; transform: scale(1.1); }
    .btn-check:checked + .btn-outline-dark { background-color: #000 !important; color: #fff !important; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/tienda/producto_detalle.blade.php ENDPATH**/ ?>