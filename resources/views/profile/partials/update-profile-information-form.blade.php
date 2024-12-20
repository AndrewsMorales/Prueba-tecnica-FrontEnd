<section>
  <header>
    <h2 class="text-lg font-medium">
      Información del perfil
    </h2>

    <p class="mt-1">
      Actualiza la información de perfil y la dirección de correo electrónico de tu cuenta.
    </p>
  </header>

  <!-- Formulario de verificación del correo -->
  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <!-- Formulario para actualizar perfil -->
  <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <div>
      <label for="name" class="form-label">Nombre</label>
      <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
      @error('name')
      <div class="text-danger mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="email" class="form-label">Correo electrónico</label>
      <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
      @error('email')
      <div class="text-danger mt-2">{{ $message }}</div>
      @enderror

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
      <div class="mt-2">
        <p>
          Su dirección de correo electrónico no está verificada.

          <button form="send-verification" class="btn btn-link p-0">
            Haga clic aquí para volver a enviar el correo electrónico de verificación.
          </button>
        </p>

        @if (session('status') === 'verification-link-sent')
        <p class="mt-2 font-medium text-success">
          Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.
        </p>
        @endif
      </div>
      @endif
    </div>

    <div class="d-flex justify-content-start gap-3 mt-4">
      <button type="submit" class="btn btn-primary">
        Guardar
      </button>

      @if (session('status') === 'profile-updated')
      <p class="text-success mt-2" id="profile-updated-message">
        Guardado.
      </p>
      @endif
    </div>
  </form>
</section>

<script>
  // Script para cerrar el mensaje de éxito automáticamente después de 2 segundos
  setTimeout(() => {
    const message = document.getElementById('profile-updated-message');
    if (message) {
      message.style.display = 'none';
    }
  }, 5000);
</script>