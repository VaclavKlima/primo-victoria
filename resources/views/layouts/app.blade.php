<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
<div>
    @include('layouts.header')
    <main id="main">
        <!-- Page Content -->
        <div class="container mt-4">
            @include('layouts.alerts')

            @yield('content')
        </div>
    </main>
</div>

<!-- Scripts -->
@yield('scripts')

</body>
</html>
