<?php $__env->startSection('title', 'Nuevo Producto - Branyey'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="bi bi-box-seam-fill me-2"></i>Nuevo Producto
            </h1>
            <p class="text-muted small mb-0">Registra un nuevo producto con sus variantes de talla y color</p>
        </div>
        <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn-action-outline">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert-error-card mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <div class="form-card">
        <form action="<?php echo e(route('admin.productos.store')); ?>" method="POST" enctype="multipart/form-data" id="productForm">
            <?php echo csrf_field(); ?>

            
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-info-circle"></i>
                    <h5>Información básica</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-tag me-1"></i>Nombre comercial <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre_comercial" class="form-input" 
                                   placeholder="Ej: Camisa Polo Premium" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-brush me-1"></i>Estilo <span class="text-danger">*</span>
                            </label>
                            <select name="estilo_id" class="form-select" required>
                                <option value="">Seleccione un estilo</option>
                                <?php $__currentLoopData = $estilos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estilo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estilo->id); ?>"><?php echo e($estilo->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-person-standing me-1"></i>Clasificación <span class="text-danger">*</span>
                            </label>
                            <select name="clasificacion_id" id="clasificacion_id" class="form-select" required>
                                <option value="">Seleccione clasificación</option>
                                <?php $__currentLoopData = $clasificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clasif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($clasif->id); ?>"><?php echo e($clasif->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-file-text me-1"></i>Descripción
                            </label>
                            <textarea name="descripcion" class="form-input" rows="3" 
                                      placeholder="Describe las características del producto..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-section">
                <div class="section-header">
                    <i class="bi bi-layers"></i>
                    <h5>Variantes del producto</h5>
                </div>
                
                <div class="variants-header">
                    <button type="button" id="add-variant" class="btn-add-variant">
                        <i class="bi bi-plus-circle me-2"></i>Agregar variante
                    </button>
                    <p class="text-muted small mb-0">Cada variante combina talla y color. La foto se asigna por color.</p>
                </div>

                <div id="variants-container">
                    
                    <div class="variant-card">
                        <div class="variant-header">
                            <span class="variant-number">Variante #1</span>
                            <button type="button" class="btn-remove-variant" disabled style="opacity: 0.5;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="variant-label">Talla</label>
                                <select name="variantes[0][talla_id]" class="form-input talla-select" required>
                                    <option value="">-- Seleccione --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="variant-label">Color</label>
                                <select name="variantes[0][color_id]" class="form-input color-select" required>
                                    <option value="">-- Seleccione color --</option>
                                    <?php $__currentLoopData = $colores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($color->id); ?>"><?php echo e(ucfirst($color->nombre)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="variant-label text-success">Precio minorista</label>
                                <input type="number" name="variantes[0][precio_minorista]" class="form-input" 
                                       step="0.01" min="0" placeholder="$0.00" required>
                            </div>
                            <div class="col-md-2">
                                <label class="variant-label text-warning">Precio mayorista</label>
                                <input type="number" name="variantes[0][precio_mayorista]" class="form-input" 
                                       step="0.01" min="0" placeholder="$0.00" required>
                            </div>
                            <div class="col-md-1">
                                <label class="variant-label text-info">Stock</label>
                                <input type="number" name="variantes[0][stock]" class="form-input" 
                                       min="0" placeholder="0" required>
                            </div>
                            <div class="col-md-2">
                                <label class="variant-label">Fotografía</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="variantes[0][foto]" class="form-input foto-input" 
                                           accept="image/*" required>
                                    <i class="bi bi-camera"></i>
                                </div>
                                <small class="form-hint foto-help d-none">Color repetido: se reutilizará la imagen</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="bi bi-save2 me-2"></i>Guardar producto
                </button>
                <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn-cancel">
                    <i class="bi bi-x-lg me-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* ===== FORM CARD ===== */
.form-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
}

.section-header i {
    font-size: 1.2rem;
    color: #667eea;
}

.section-header h5 {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #1a1a2e;
    margin: 0;
}

/* ===== FORM GROUPS ===== */
.form-group {
    margin-bottom: 0.25rem;
}

.form-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.form-input, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 1.5px solid #e9ecef;
    border-radius: 16px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-input {
    resize: vertical;
}

/* ===== VARIANTES ===== */
.variants-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.btn-add-variant {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-add-variant:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
}

.variant-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.variant-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
}

.variant-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px dashed #dee2e6;
}

.variant-number {
    font-size: 0.75rem;
    font-weight: 700;
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    padding: 4px 12px;
    border-radius: 20px;
}

.btn-remove-variant {
    background: transparent;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-remove-variant:hover:not(:disabled) {
    background: rgba(220, 53, 69, 0.1);
    transform: scale(1.05);
}

.btn-remove-variant:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.variant-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    margin-bottom: 0.4rem;
}

/* ===== FILE INPUT ===== */
.file-input-wrapper {
    position: relative;
}

.file-input-wrapper input[type="file"] {
    padding: 0.75rem 1rem;
    padding-left: 2.5rem;
    cursor: pointer;
}

.file-input-wrapper i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
    pointer-events: none;
}

.form-hint {
    display: block;
    font-size: 0.65rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* ===== ALERTAS ===== */
.alert-error-card {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 0.85rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 500;
    border-left: 3px solid #dc3545;
}

.alert-error-card ul {
    padding-left: 1.5rem;
    margin: 0;
}

/* ===== BOTONES ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.75rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-save:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #667eea, #764ba2);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

.btn-action-outline {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1.25rem;
    background: transparent;
    color: #6c757d;
    border: 1.5px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action-outline:hover {
    background: #f8f9fa;
    color: #dc3545;
    border-color: #dc3545;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-card {
        padding: 1.5rem;
    }
    
    .variants-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .btn-add-variant {
        width: 100%;
        justify-content: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-save, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>

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
        select.innerHTML = '<option value="">-- Seleccione talla --</option>';

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
    const rows = document.querySelectorAll('.variant-card');
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
    const firstRow = document.querySelector('.variant-card');
    const newRow = firstRow.cloneNode(true);
    const variantNumber = variantIndex + 1;
    
    // Actualizar número de variante
    const variantHeader = newRow.querySelector('.variant-number');
    variantHeader.textContent = `Variante #${variantNumber}`;
    
    // Habilitar botón de eliminar en la nueva fila
    const removeBtn = newRow.querySelector('.btn-remove-variant');
    removeBtn.disabled = false;
    removeBtn.style.opacity = '1';
    
    // Limpiar valores de inputs
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
    
    // Limpiar ayuda de foto
    const fotoHelp = newRow.querySelector('.foto-help');
    if (fotoHelp) fotoHelp.classList.add('d-none');
    
    container.appendChild(newRow);
    
    // Actualizar tallas en la nueva fila
    const clasificacionId = document.getElementById('clasificacion_id').value;
    updateTallaSelects(clasificacionId);
    syncFotoInputsByColor();
    
    variantIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-variant')) {
        const rows = document.querySelectorAll('.variant-card');
        if (rows.length > 1) {
            e.target.closest('.variant-card').remove();
            // Renumerar variantes restantes
            document.querySelectorAll('.variant-card').forEach((card, idx) => {
                const numberSpan = card.querySelector('.variant-number');
                numberSpan.textContent = `Variante #${idx + 1}`;
            });
            syncFotoInputsByColor();
        } else {
            alert("Debe haber al menos una variante.");
        }
    }
});

// Inicializar
syncFotoInputsByColor();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/productos/create.blade.php ENDPATH**/ ?>