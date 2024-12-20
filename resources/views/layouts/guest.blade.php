<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>App prueba front end</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-dark">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center bg-dark">
        <!-- Logo -->
        <div class="mb-4">
            <a href="/">
                <img src="{{ asset('img/atom-logo-horizontal-dark-grupo-alianza.webp') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="max-width: 300px;">
            </a>
        </div>

        <!-- Content -->
        <div class="card shadow-lg w-100" style="max-width: 400px;">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>