<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-light text-xl">
			Inicio
		</h2>
	</x-slot>
	@if (!$cocteles->isEmpty())
	<div id="carouselExampleCaptions" class="carousel slide">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
		</div>
		<div class="carousel-inner">
			@foreach ($cocteles as $index => $coctel)
			<div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
				<img src="{{ $coctel->url_imagen }}" class="d-block mx-auto h-25" alt="...">
				<div class="carousel-caption d-none d-md-block">
					<h5>{{ $coctel->nombre }}</h5>
				</div>
			</div>
			@endforeach

		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
	@endif
	<div class="py-12">
		<div class="container-lg">
			<div class="bg-dark text-light">
				<div class="p-6">
					<p class="fs-4">
						Esta es una página diseñada especialmente para los amantes de los cócteles. Aquí podrás explorar una amplia variedad de recetas, desde los clásicos hasta los más innovadores. Cada cóctel incluye una descripción detallada de los ingredientes necesarios y un paso a paso para su preparación, asegurando que puedas recrearlos con facilidad en casa. Descubre nuevas combinaciones, aprende técnicas de preparación y disfruta del fascinante mundo de la mixología. ¡Perfecta para sorprender a tus invitados!
					</p>
				</div>
			</div>
		</div>
	</div>

</x-app-layout>