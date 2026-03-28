<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="{{ $description ?? 'Your one-stop creative shop for personalized gifts, custom prints, bag charms, keychains, and 3D printed wonders.' }}"/>
    <title>{{ $title ?? 'ArtsyCrate — Prints, Customs & Creative Fun' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}"/>

    @stack('styles')
</head>
<body>

    @include('layout.navbar', ['active' => $active ?? ''])

    @yield('content')

    @include('layout.cta-band')
    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>lucide.createIcons();</script>

    @stack('scripts')
</body>
</html>