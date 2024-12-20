<x-guest-layout>
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-11 col-md-12">
				<h3 class="text-center mb-4">Iniciar sesión</h3>

				<!-- Session Status -->
				@if(session('status'))
				<div class="alert alert-success mb-4">
					{{ session('status') }}
				</div>
				@endif

				<form method="POST" action="{{ route('login') }}">
					@csrf

					<!-- Email Address -->
					<div class="mb-3">
						<label for="email" class="form-label">Correo electronico</label>
						<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
						@error('email')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>

					<!-- Password -->
					<div class="mb-3">
						<label for="password" class="form-label">Contraseña</label>
						<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
						@error('password')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>

					<div class="d-flex justify-content-between align-items-center">
						<a class="btn btn-secondary" href="{{ route('register') }}">
							Registrate
						</a>

						<button type="submit" class="btn btn-primary">
							{{ __('Iniciar sesión') }}
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-guest-layout>