<section class="space-y-6">
  <header>
    <h2 class="text-lg font-medium">
      Eliminar cuenta
    </h2>
    <p class="mt-1">
      Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán de forma permanente. Antes de eliminar su cuenta, descargue todos los datos o la información que desee conservar.
    </p>
  </header>

  <!-- Botón para activar el modal -->
  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
    Eliminar cuenta
  </button>

  <!-- Modal de confirmación -->
  <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="post" action="{{ route('profile.destroy') }}" class="modal-content p-4 bg-dark text-light">
        @csrf
        @method('delete')

        <div class="modal-header">
          <h5 class="modal-title text-light" id="confirm-user-deletionLabel">
            ¿Estás seguro de que quieres eliminar tu cuenta?
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p class="mt-1 text-light">
            Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán de forma permanente. Ingrese su contraseña para confirmar que desea eliminar su cuenta de forma permanente.
          </p>

          <div class="mt-4">
            <label for="password" class="form-label text-light">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña" required />
            @error('password')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger ms-3">
            Eliminar cuenta
          </button>

          <button type="button" class="btn btn-secondary ms-3" data-bs-dismiss="modal">
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</section>