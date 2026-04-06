<section>
    <div class="mb-3">
        <h4 class="fw-bold text-danger mb-1"><i class="bi bi-trash3 me-2"></i>Eliminar cuenta</h4>
        <p class="text-muted mb-0">Una vez eliminada tu cuenta, todos tus datos serán borrados permanentemente. Si deseas conservar información, descárgala antes de continuar.</p>
    </div>
    <button class="btn btn-outline-danger px-4 fw-bold" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <i class="bi bi-trash3 me-1"></i> Eliminar cuenta
    </button>
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')
            <h5 class="fw-bold text-danger mb-2">¿Estás seguro de que deseas eliminar tu cuenta?</h5>
            <p class="mb-3 text-muted">Esta acción no se puede deshacer. Ingresa tu contraseña para confirmar.</p>
            <div class="mb-3">
                <x-input-label for="password" value="Contraseña" />
                <x-text-input id="password" name="password" type="password" class="form-control" placeholder="Contraseña" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar definitivamente</button>
            </div>
        </form>
    </x-modal>
</section>
