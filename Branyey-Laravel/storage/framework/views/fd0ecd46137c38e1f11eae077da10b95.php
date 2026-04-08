<section>
    <div class="mb-3">
        <h4 class="fw-bold text-warning mb-1">
            <i class="bi bi-person-x me-2"></i>Desactivar cuenta
        </h4>
        <p class="text-muted mb-0">
            Al desactivar tu cuenta, perderás acceso al sistema y no podrás realizar compras. 
            Tus datos se conservarán por si decides reactivarla en el futuro.
            Si deseas conservar tu información de compras, descarga tus datos antes de continuar.
        </p>
    </div>
    
    <button class="btn btn-outline-warning px-4 fw-bold" 
            x-data="" 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deactivation')">
        <i class="bi bi-person-x me-1"></i> Desactivar cuenta
    </button>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'confirm-user-deactivation','show' => $errors->userDeletion->isNotEmpty(),'focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'confirm-user-deactivation','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->userDeletion->isNotEmpty()),'focusable' => true]); ?>
        <form method="post" action="<?php echo e(route('profile.destroy')); ?>" class="p-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>
            
            <div class="text-center mb-3">
                <div class="deactivation-icon-wrapper mx-auto mb-3">
                    <i class="bi bi-person-x fs-1"></i>
                </div>
                <h5 class="fw-bold text-warning mb-2">¿Desactivar tu cuenta?</h5>
                <p class="text-muted mb-2">
                    Perderás acceso al sistema y no podrás realizar compras.
                </p>
                <div class="alert alert-info small mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Tus datos permanecerán en nuestro sistema. Puedes contactar al soporte si deseas reactivar tu cuenta.
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label fw-bold small text-uppercase">
                    <i class="bi bi-key me-1"></i>Confirmar contraseña
                </label>
                <input id="password" name="password" type="password" 
                       class="form-control rounded-pill" 
                       placeholder="Ingresa tu contraseña para confirmar">
                <?php if($errors->userDeletion->has('password')): ?>
                    <div class="text-danger small mt-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <?php echo e($errors->userDeletion->first('password')); ?>

                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="button" class="btn btn-light rounded-pill px-4" 
                        x-on:click="$dispatch('close')">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">
                    <i class="bi bi-person-x me-1"></i> Desactivar cuenta
                </button>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</section>

<style>
.deactivation-icon-wrapper {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.deactivation-icon-wrapper i {
    font-size: 2rem;
    color: #ffc107;
}

.btn-outline-warning {
    border: 1.5px solid #ffc107;
    color: #ffc107;
    background: transparent;
    transition: all 0.3s ease;
}

.btn-outline-warning:hover {
    background: #ffc107;
    color: #1a1a2e;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 193, 7, 0.3);
}
</style><?php /**PATH C:\Users\USER\Documents\Branyeygit\Branyey-Laravel\resources\views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>