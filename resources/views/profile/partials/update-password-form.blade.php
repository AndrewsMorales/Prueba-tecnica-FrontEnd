<section>
  <header>
    <h2 class="text-lg font-medium">
      Actualizar contraseña
    </h2>

    <p class="mt-1">
      Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerla segura.
    </p>
  </header>

  <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('put')

    <div>
      <label for="update_password_current_password" class="form-label">Contraseña actual</label>
      <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
      @error('current_password')
      <div class="text-danger mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="update_password_password" class="form-label">Nueva contraseña</label>
      <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
      @error('password')
      <div class="text-danger mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="update_password_password_confirmation" class="form-label">Confirmar Contraseña</label>
      <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control " autocomplete="new-password" />
      @error('password_confirmation')
      <div class="text-danger mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex justify-content-start gap-3 mt-4">
      <button type="submit" class="btn btn-primary">
        Guardar
      </button>

      @if (session('status') === 'password-updated')
      <p class="text-sm text-success mt-2" id="password-updated-message">
        Guardado.
      </p>
      @endif
    </div>
  </form>
</section>

<script>
  // Script para cerrar el mensaje de éxito automáticamente después de 2 segundos
  setTimeout(() => {
    const message = document.getElementById('password-updated-message');
    if (message) {
      message.style.display = 'none';
    }
  }, 4000);
</script>