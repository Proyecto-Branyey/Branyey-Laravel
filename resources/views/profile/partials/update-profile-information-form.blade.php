<section>
    <div class="mb-3">
        <h4 class="fw-bold text-primary mb-1"><i class="bi bi-person-lines-fill me-2"></i>Información de perfil</h4>
        <p class="text-muted mb-0">Actualiza tus datos personales y correo electrónico.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <script>
        function enableProfileEdit() {
            document.querySelectorAll('.profile-editable').forEach(el => el.removeAttribute('disabled'));
            document.getElementById('profile-edit-btn').style.display = 'none';
            document.getElementById('profile-save-row').style.display = 'flex';
        }
    </script>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')
        <div class="row g-3">
            <div class="col-md-6">
                <x-input-label for="username" :value="__('Usuario')" />
                <x-text-input id="username" name="username" type="text" class="form-control profile-editable" :value="old('username', $user->username)" required autofocus autocomplete="username" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>
            <div class="col-md-6">
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" name="email" type="email" class="form-control profile-editable" :value="old('email', $user->email)" required autocomplete="username" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Tu correo no está verificado.') }}
                            <button form="send-verification" class="btn btn-link p-0 align-baseline">Reenviar verificación</button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-success">
                                {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <x-input-label for="nombre_completo" :value="__('Nombre completo')" />
                <x-text-input id="nombre_completo" name="nombre_completo" type="text" class="form-control profile-editable" :value="old('nombre_completo', $user->nombre_completo)" autocomplete="off" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('nombre_completo')" />
            </div>
            <div class="col-md-6">
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" name="telefono" type="text" class="form-control profile-editable" :value="old('telefono', $user->telefono)" autocomplete="off" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
            </div>
            <div class="col-md-6">
                <x-input-label for="direccion_defecto" :value="__('Dirección de envío')" />
                <x-text-input id="direccion_defecto" name="direccion_defecto" type="text" class="form-control profile-editable" :value="old('direccion_defecto', $user->direccion_defecto)" autocomplete="off" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('direccion_defecto')" />
            </div>
            <div class="col-md-3">
                <x-input-label for="ciudad_defecto" :value="__('Ciudad')" />
                <x-text-input id="ciudad_defecto" name="ciudad_defecto" type="text" class="form-control profile-editable" :value="old('ciudad_defecto', $user->ciudad_defecto)" autocomplete="off" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('ciudad_defecto')" />
            </div>
            <div class="col-md-3">
                <x-input-label for="departamento_defecto" :value="__('Departamento')" />
                <x-text-input id="departamento_defecto" name="departamento_defecto" type="text" class="form-control profile-editable" :value="old('departamento_defecto', $user->departamento_defecto)" autocomplete="off" disabled />
                <x-input-error class="mt-2" :messages="$errors->get('departamento_defecto')" />
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-end align-items-center gap-3" id="profile-save-row" style="display:none;">
            <x-primary-button class="btn btn-primary px-4">Guardar cambios</x-primary-button>
            @if (session('status') === 'profile-updated')
                <span class="text-success small">Guardado.</span>
            @endif
        </div>
        <div class="mt-4 d-flex justify-content-end align-items-center gap-3" id="profile-edit-btn">
            <button type="button" class="btn btn-outline-primary px-4" onclick="enableProfileEdit()">
                <i class="bi bi-pencil me-1"></i> Editar
            </button>
        </div>
    </form>
</section>
