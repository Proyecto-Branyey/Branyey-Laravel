<?php $__env->startSection('title', 'Nuevo Producto - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    <?php if($errors->any()): ?>
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <ul class="mb-0 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.productos.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Nuevo Producto Branyey</h5>
                <button type="button" id="add-variant" class="btn btn-sm btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Color/Talla
                </button>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nombre Comercial</label>
                        <input type="text" name="nombre_comercial" class="form-control" placeholder="Ej: Camisa Polo Premium" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción del producto"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Estilo</label>
                        <select name="estilo_id" class="form-select" required>
                            <?php $__currentLoopData = $estilos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estilo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estilo->id); ?>"><?php echo e($estilo->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Clasificación de Talla</label>
                        <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                            <option value="">Seleccione clasificación</option>
                            <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clasif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($clasif->id); ?>"><?php echo e($clasif->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold text-secondary text-uppercase mb-3 small">Configuración de Variantes (Foto por color)</h6>

                <div id="variants-container">
                    <div class="variant-row border rounded-3 p-3 mb-3 bg-light shadow-sm">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="small fw-bold">1. Talla</label>
                                <select name="variantes[0][talla_id]" class="form-select talla-select" required>
                                    <option value="">-- Seleccione clasificación primero --</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold">2. Color</label>
                                <select name="variantes[0][color_id]" class="form-select color-select" required>
                                    <option value="">-- Color --</option>
                                    <?php $__currentLoopData = $colores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($color->id); ?>"><?php echo e(strtoupper($color->nombre)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-success">Precio Minorista</label>
                                <input type="number" name="variantes[0][precio_minorista]" class="form-control" step="0.01" min="0" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold text-warning">Precio Mayorista</label>
                                <input type="number" name="variantes[0][precio_mayorista]" class="form-control" step="0.01" min="0" required>
                            </div>

                            <div class="col-md-1">
                                <label class="small fw-bold text-info">Stock</label>
                                <input type="number" name="variantes[0][stock]" class="form-control" min="0" required>
                            </div>

                            <div class="col-md-2">
                                <label class="small fw-bold">Fotografía</label>
                                <input type="file" name="variantes[0][foto]" class="form-control form-control-sm foto-input" accept="image/*" required>
                                <small class="text-muted d-none foto-help">Color repetido: se reutiliza la imagen del mismo color.</small>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger remove-row w-100"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-dark btn-lg w-100 shadow-lg fw-bold">
                        <i class="bi bi-save2 me-2"></i> GUARDAR PRODUCTO COMPLETO
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let variantIndex = 1;

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

// Función para actualizar todos los selects de tallas
function updateTallaSelects(clasificacionId) {
    const selects = document.querySelectorAll('.talla-select');

    selects.forEach(select => {
        select.innerHTML = '<option value="">-- Talla --</option>';

        if (clasificacionId && tallasPorClasificacion[clasificacionId]) {
            tallasPorClasificacion[clasificacionId].forEach(talla => {
                const option = document.createElement('option');
                option.value = talla.id;
                option.textContent = talla.nombre;
                select.appendChild(option);
            });
        }
    });
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
        } else {
            fotoInput.disabled = false;
            fotoInput.required = !!colorId;
            if (fotoHelp) fotoHelp.classList.add('d-none');

            if (colorId) {
                firstColorRow[colorId] = true;
            }
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
        syncFotoInputsByColor();
    }
});

document.getElementById('add-variant').addEventListener('click', function() {
    const container = document.getElementById('variants-container');
    const firstRow = document.querySelector('.variant-row');
    const newRow = firstRow.cloneNode(true);

    // Limpiar valores de inputs
    newRow.querySelectorAll('input, select').forEach(input => {
        if(input.type === 'file') {
            input.value = '';
        } else if(input.type === 'number') {
            input.value = '';
        } else if(input.classList.contains('talla-select')) {
            // El select de tallas se actualizará automáticamente por updateTallaSelects
            input.value = '';
        } else {
            input.value = '';
        }
        input.name = input.name.replace(/\[\d+\]/, `[${variantIndex}]`);
    });

    container.appendChild(newRow);

    // Actualizar tallas en la nueva fila
    const clasificacionId = document.getElementById('clasificacion_id').value;
    updateTallaSelects(clasificacionId);
    syncFotoInputsByColor();

    variantIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        if (document.querySelectorAll('.variant-row').length > 1) {
            e.target.closest('.variant-row').remove();
            syncFotoInputsByColor();
        }
        else alert("Debe haber al menos una variante.");
    }
});

syncFotoInputsByColor();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\resources\views/admin/productos/create.blade.php ENDPATH**/ ?>