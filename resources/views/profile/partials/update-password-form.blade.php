<section>
    <div class="mb-3">
        <h4 class="fw-bold text-secondary mb-1"><i class="bi bi-shield-lock me-2"></i>Cambiar contraseña</h4>
        <p class="text-muted mb-0">Asegúrate de usar una contraseña segura y fácil de recordar.</p>
    </div>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="row g-3">
            <div class="col-md-4">
                <x-input-label for="update_password_current_password" :value="'Contraseña actual'" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
            <div class="col-md-4">
                <x-input-label for="update_password_password" :value="'Nueva contraseña'" />
                <x-text-input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
            <div class="col-md-4">
                <x-input-label for="update_password_password_confirmation" :value="'Confirmar nueva contraseña'" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-end align-items-center gap-3">
            <x-primary-button class="btn btn-primary px-4">Guardar contraseña</x-primary-button>
            @if (session('status') === 'password-updated')
                <span class="text-success small">Contraseña actualizada.</span>
            @endif
        </div>
    </form>
</section>
