<?php $__env->startSection('title', 'Editar Producto - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <?php if($errors->any()): ?>
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <ul class="mb-0 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.productos.update', $producto)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Producto: <?php echo e($producto->nombre_comercial); ?></h5>
                <button type="button" id="add-variant" class="btn btn-sm btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Color/Talla
                </button>
            </div>

            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nombre Comercial</label>
                        <input type="text" name="nombre_comercial" class="form-control" placeholder="Ej: Camisa Polo Premium" value="<?php echo e($producto->nombre_comercial); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción del producto"><?php echo e($producto->descripcion); ?></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Estilo</label>
                        <select name="estilo_id" class="form-select" required>
                            <?php $__currentLoopData = $estilos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estilo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estilo->id); ?>" <?php echo e($producto->estilo_id == $estilo->id ? 'selected' : ''); ?>><?php echo e($estilo->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Clasificación de Talla</label>
                        <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                            <option value="">Seleccione clasificación</option>
                            <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clasif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($clasif->id); ?>" <?php echo e($producto->clasificacion_id == $clasif->id ? 'selected' : ''); ?>><?php echo e($clasif->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold text-secondary text-uppercase mb-3 small">Configuración de Variantes (Foto por color)</h6>

                <div id="variants-container">
                    <?php $__currentLoopData = $producto->variantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="variant-row border rounded-3 p-3 mb-3 bg-light shadow-sm">
                        <input type="hidden" name="variantes[<?php echo e($index); ?>][id]" value="<?php echo e($variante->id); ?>">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="small fw-bold">1. Talla</label>
                                <select name="variantes[<?php echo e($index); ?>][talla_id]" class="form-select talla-select" required>
                                    <option value="">-- Seleccione clasificación primero --</option>
                                    <?php $__currentLoopData = $tallas->where('clasificacion_id', $producto->clasificacion_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($talla->id); ?>" <?php echo e($variante->talla_id == $talla->id ? 'selected' : ''); ?>><?php echo e($talla->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold">2. Color</label>
                                <select name="variantes[<?php echo e($index); ?>][color_id]" class="form-select color-select" required>
                                    <option value="">-- Color --</option>
                                    <?php $__currentLoopData = $colores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($color->id); ?>" <?php echo e($variante->colores->first()?->id == $color->id ? 'selected' : ''); ?>><?php echo e(strtoupper($color->nombre)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-success">Precio Minorista</label>
                                <input type="number" name="variantes[<?php echo e($index); ?>][precio_minorista]" class="form-control" step="0.01" min="0" value="<?php echo e($variante->precio_minorista); ?>" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-warning">Precio Mayorista</label>
                                <input type="number" name="variantes[<?php echo e($index); ?>][precio_mayorista]" class="form-control" step="0.01" min="0" value="<?php echo e($variante->precio_mayorista); ?>" required>
                            </div>

                            <div class="col-md-1">
                                <label class="small fw-bold text-info">Stock</label>
                                <input type="number" name="variantes[<?php echo e($index); ?>][stock]" class="form-control" min="0" value="<?php echo e($variante->stock); ?>" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold">Fotografía</label>
                                <input type="file" name="variantes[<?php echo e($index); ?>][foto]" class="form-control form-control-sm foto-input" accept="image/*">
                                <?php $imagenColor = $imagenesPorColor[$variante->colores->first()?->id] ?? null; ?>
                                <small class="text-muted d-none foto-help">Color repetido: se reutiliza la imagen del mismo color.</small>
                                <div class="foto-preview mt-1">
                                    <?php if($imagenColor): ?>
                                        <small class="text-muted d-block">Imagen actual (se mantiene si no subes otra): <a href="<?php echo e(Storage::url($imagenColor->url)); ?>" target="_blank">Ver</a></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger remove-row w-100"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div id="pending-changes-alert" class="alert alert-warning border-0 shadow-sm mt-3 d-none" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Tienes cambios pendientes. Para guardarlos debes presionar <strong>ACTUALIZAR PRODUCTO</strong>.
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-dark btn-lg w-100 shadow-lg fw-bold">
                        <i class="bi bi-save2 me-2"></i> ACTUALIZAR PRODUCTO
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let variantIndex = <?php echo e(count($producto->variantes)); ?>;
let hasPendingChanges = false;
const form = document.querySelector('form[action="<?php echo e(route('admin.productos.update', $producto)); ?>"]');
const pendingChangesAlert = document.getElementById('pending-changes-alert');

function markPendingChanges() {
    hasPendingChanges = true;
    pendingChangesAlert.classList.remove('d-none');
}

function clearPendingChanges() {
    hasPendingChanges = false;
    pendingChangesAlert.classList.add('d-none');
}

// Datos de tallas por clasificación
const tallasPorClasificacion = {
    <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clasif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($clasif->id); ?>: [
            <?php $__currentLoopData = $tallas->where('clasificacion_id', $clasif->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {id: <?php echo e($talla->id); ?>, nombre: '<?php echo e($talla->nombre); ?>'},
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
};

const imagenesPorColor = {
    <?php $__currentLoopData = $imagenesPorColor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colorId => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($colorId); ?>: '<?php echo e(Storage::url($img->url)); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
};

// Función para actualizar todos los selects de tallas
function updateTallaSelects(clasificacionId) {
    const selects = document.querySelectorAll('.talla-select');

    selects.forEach(select => {
        const currentValue = select.value;
        select.innerHTML = '<option value="">-- Talla --</option>';

        if (clasificacionId && tallasPorClasificacion[clasificacionId]) {
            tallasPorClasificacion[clasificacionId].forEach(talla => {
                const option = document.createElement('option');
                option.value = talla.id;
                option.textContent = talla.nombre;
                if (currentValue == talla.id) option.selected = true;
                select.appendChild(option);
            });
        }
    });
}

function renderPreview(row, colorId, localFileUrl = null) {
    const preview = row.querySelector('.foto-preview');
    if (!preview) return;

    if (localFileUrl) {
        preview.innerHTML = `<small class="text-success d-block">Nueva imagen seleccionada</small><img src="${localFileUrl}" alt="preview" class="img-thumbnail mt-1" style="max-height: 64px;">`;
        return;
    }

    if (colorId && imagenesPorColor[colorId]) {
        const url = imagenesPorColor[colorId];
        preview.innerHTML = `<small class="text-muted d-block">Imagen actual (se mantiene si no subes otra): <a href="${url}" target="_blank">Ver</a></small>`;
        return;
    }

    preview.innerHTML = '';
}

function syncFotoInputsByColor() {
    const rows = document.querySelectorAll('.variant-row');
    const firstColorRow = {};

    rows.forEach(row => {
        const colorSelect = row.querySelector('.color-select');
        const fotoInput = row.querySelector('.foto-input');
        const fotoHelp = row.querySelector('.foto-help');

        if (!colorSelect || !fotoInput) return;

        const colorId = colorSelect.value;
        const isDuplicateColor = colorId && firstColorRow[colorId];

        if (isDuplicateColor) {
            fotoInput.value = '';
            fotoInput.required = false;
            fotoInput.disabled = true;
            if (fotoHelp) fotoHelp.classList.remove('d-none');
            renderPreview(row, colorId);
        } else {
            fotoInput.disabled = false;
            fotoInput.required = false;
            if (fotoHelp) fotoHelp.classList.add('d-none');

            if (colorId) {
                firstColorRow[colorId] = true;
            }

            renderPreview(row, colorId);
        }
    });
}

// Event listener para cambio de clasificación
document.getElementById('clasificacion_id').addEventListener('change', function() {
    const clasificacionId = this.value;
    updateTallaSelects(clasificacionId);
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('color-select')) {
        const row = e.target.closest('.variant-row');
        if (row) {
            const fotoInput = row.querySelector('.foto-input');
            if (fotoInput) fotoInput.value = '';
            renderPreview(row, e.target.value);
        }
        syncFotoInputsByColor();
        markPendingChanges();
    }

    if (e.target.classList.contains('foto-input')) {
        const row = e.target.closest('.variant-row');
        if (!row) return;

        if (e.target.files && e.target.files[0]) {
            const tmpUrl = URL.createObjectURL(e.target.files[0]);
            renderPreview(row, null, tmpUrl);
        } else {
            const colorSelect = row.querySelector('.color-select');
            renderPreview(row, colorSelect ? colorSelect.value : null);
        }
    }
});

document.getElementById('add-variant').addEventListener('click', function() {
    const container = document.getElementById('variants-container');
    const firstRow = document.querySelector('.variant-row');

    // Crear nueva fila basada en la primera
    const newRow = firstRow.cloneNode(true);

    // Limpiar valores de inputs
    newRow.querySelectorAll('input[type="hidden"]').forEach(input => input.remove()); // Remover ID de variante existente
    newRow.querySelectorAll('input, select').forEach(input => {
        if(input.type === 'file') {
            input.value = '';
        } else if(input.type === 'number') {
            input.value = '';
        } else if(input.classList.contains('talla-select')) {
            input.value = '';
        } else {
            input.value = '';
        }
        input.name = input.name.replace(/\[\d+\]/, `[${variantIndex}]`);
    });

    const preview = newRow.querySelector('.foto-preview');
    if (preview) preview.innerHTML = '';

    const fotoHelp = newRow.querySelector('.foto-help');
    if (fotoHelp) fotoHelp.classList.add('d-none');

    container.appendChild(newRow);

    // Actualizar tallas en la nueva fila
    const clasificacionId = document.getElementById('clasificacion_id').value;
    updateTallaSelects(clasificacionId);
    syncFotoInputsByColor();

    variantIndex++;
    markPendingChanges();
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        if (document.querySelectorAll('.variant-row').length > 1) {
            e.target.closest('.variant-row').remove();
            syncFotoInputsByColor();
            markPendingChanges();
        } else {
            alert("Debe haber al menos una variante.");
        }
    }
});

document.addEventListener('input', function(e) {
    if (e.target.closest('form[action="<?php echo e(route('admin.productos.update', $producto)); ?>"]')) {
        markPendingChanges();
    }
});

form.addEventListener('submit', function() {
    clearPendingChanges();
});

window.addEventListener('beforeunload', function(e) {
    if (!hasPendingChanges) {
        return;
    }

    e.preventDefault();
    e.returnValue = '';
});

// Inicializar tallas al cargar
document.addEventListener('DOMContentLoaded', function() {
    const clasificacionId = document.getElementById('clasificacion_id').value;
    if (clasificacionId) {
        updateTallaSelects(clasificacionId);
    }
    syncFotoInputsByColor();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/productos/edit.blade.php ENDPATH**/ ?>