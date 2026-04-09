

<?php $__env->startSection('admin-content'); ?>
<div class="container-fluid mt-2 mass-mail-page">
    <div class="mail-hero mb-4 p-4 rounded-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h2 class="mb-1 fw-bold">Centro de correo masivo</h2>
                <p class="mb-0">Comunica novedades, anuncios y avisos operativos a clientes filtrados.</p>
            </div>
            <span class="badge text-bg-light px-3 py-2 fs-6">Admin</span>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.mail.send')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row g-4">
            <div class="col-12 col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Destinatarios</h6>
                            <span class="text-muted small" id="recipient_hint">Selecciona un modo</span>
                        </div>

                        <div class="form-check mode-pill mb-2">
                            <input class="form-check-input" type="radio" name="recipient_mode" id="mode_all" value="all" <?php echo e(old('recipient_mode', 'all') === 'all' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="mode_all">Todos los usuarios activos con correo</label>
                        </div>

                        <div class="form-check mode-pill mb-2">
                            <input class="form-check-input" type="radio" name="recipient_mode" id="mode_role" value="role" <?php echo e(old('recipient_mode') === 'role' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="mode_role">Filtrar por rol</label>
                        </div>

                        <div class="mb-3" id="role_filter_box" style="display: none;">
                            <label for="role_id" class="form-label">Rol</label>
                            <select class="form-select" id="role_id" name="role_id">
                                <option value="">Selecciona un rol</option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>" <?php echo e(old('role_id') == $role->id ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($role->nombre)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-check mode-pill mb-2">
                            <input class="form-check-input" type="radio" name="recipient_mode" id="mode_selected" value="selected" <?php echo e(old('recipient_mode') === 'selected' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="mode_selected">Seleccionar usuarios específicos</label>
                        </div>

                        <div id="selected_users_box" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="user_search" class="form-label mb-0">Buscar usuario</label>
                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-muted" id="selected_count">0 seleccionados</small>
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="select_all_users">
                                        <label class="form-check-label small" for="select_all_users">Todos visibles</label>
                                    </div>
                                </div>
                            </div>

                            <input type="text" class="form-control mb-2" id="user_search" placeholder="Nombre, correo o rol...">

                            <div class="user-list border rounded-3 p-2">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check user-item p-2 rounded-3"
                                         data-search="<?php echo e(strtolower(($user->nombre_completo ?? '') . ' ' . ($user->email ?? '') . ' ' . ($user->rol->nombre ?? ''))); ?>">
                                        <input class="form-check-input user-checkbox" type="checkbox" name="selected_users[]" id="user_<?php echo e($user->id); ?>" value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, old('selected_users', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label ms-1" for="user_<?php echo e($user->id); ?>">
                                            <span class="fw-semibold"><?php echo e($user->nombre_completo ?: $user->email); ?></span><br>
                                            <small class="text-muted"><?php echo e($user->email); ?></small>
                                            <span class="badge text-bg-light border ms-1"><?php echo e(ucfirst($user->rol->nombre ?? 'sin rol')); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Contenido del correo</h6>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Asunto</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" placeholder="Ej: Nuevo catálogo disponible esta semana" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="message" name="message" rows="11" required><?php echo e(old('message')); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen del anuncio</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg,image/webp">
                            <small class="form-text text-muted">Opcional. Formatos permitidos: JPG, PNG o WEBP. Maximo 4 MB.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">Enviar correo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .mass-mail-page .mail-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 45%, #334155 100%);
        color: #f8fafc;
    }

    .mass-mail-page .mode-pill {
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.7rem 0.85rem;
    }

    .mass-mail-page .mode-pill:has(input:checked) {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .mass-mail-page .user-list {
        max-height: 300px;
        overflow-y: auto;
        background: #f8fafc;
    }

    .mass-mail-page .user-item:hover {
        background: #eef2ff;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateRecipientSections() {
        const mode = document.querySelector('input[name="recipient_mode"]:checked')?.value;
        const roleBox = document.getElementById('role_filter_box');
        const selectedBox = document.getElementById('selected_users_box');
        const hint = document.getElementById('recipient_hint');

        roleBox.style.display = mode === 'role' ? 'block' : 'none';
        selectedBox.style.display = mode === 'selected' ? 'block' : 'none';

        if (mode === 'all') {
            hint.textContent = 'Se enviara a todos los usuarios activos';
        } else if (mode === 'role') {
            hint.textContent = 'Se enviara solo al rol seleccionado';
        } else {
            hint.textContent = 'Se enviara solo a usuarios marcados';
        }
    }

    function updateSelectedCount() {
        const total = document.querySelectorAll('.user-checkbox:checked').length;
        const countLabel = document.getElementById('selected_count');
        if (countLabel) {
            countLabel.textContent = total + ' seleccionados';
        }
    }

    document.querySelectorAll('input[name="recipient_mode"]').forEach((radio) => {
        radio.addEventListener('change', updateRecipientSections);
    });

    updateRecipientSections();
    updateSelectedCount();

    const searchInput = document.getElementById('user_search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            document.querySelectorAll('.user-item').forEach((item) => {
                const haystack = item.getAttribute('data-search');
                item.style.display = haystack.includes(term) ? '' : 'none';
            });
        });
    }

    const selectAll = document.getElementById('select_all_users');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.user-item').forEach((item) => {
                if (item.style.display === 'none') {
                    return;
                }

                const checkbox = item.querySelector('.user-checkbox');
                if (checkbox) {
                    checkbox.checked = this.checked;
                }
            });

            updateSelectedCount();
        });
    }

    document.querySelectorAll('.user-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/admin/mail/create.blade.php ENDPATH**/ ?>