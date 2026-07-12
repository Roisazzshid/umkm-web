<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Rintasa' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/logo-rintasa.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gradient-to-br from-primary-light via-white to-accent-light text-ink font-sans min-h-screen flex flex-col items-center justify-center px-5 py-10">
    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
        <img src="{{ asset('assets/logo/logo-rintasa.png') }}" alt="Logo Rintasa" class="w-9 h-9 object-contain">
        <span class="font-bold text-ink">Rintasa</span>
    </a>
    <div class="w-full">
        {{ $slot }}
    </div>
</body>

</html>
