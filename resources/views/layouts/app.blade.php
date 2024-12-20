<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>App prueba front end</title>

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-dark">
  <div class="min-vh-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
    <header class="bg-dark shadow-sm">
      <div class="container py-4">
        <h1 class="text-light">{{ $header }}</h1>
      </div>
    </header>
    @endisset

    <!-- Page Content -->
    <main>
      <div class="container py-4">
        {{ $slot }}
      </div>
    </main>
  </div>
</body>

</html>