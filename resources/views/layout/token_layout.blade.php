<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- .. Other head code  -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
</head>
<body>

<main>
    <!-- .. Main HTML -->
    @yield('content')
</main>

</body>
</html>
