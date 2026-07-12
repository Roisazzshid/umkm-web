<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'UMKM Nawasena' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/logo-rintasa.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-wite-50 text-ink font-sans">
    <x-navbar />
    <main>
        {{ $slot }}
    </main>
    <x-footer />
</body>

</html>
