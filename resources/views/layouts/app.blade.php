<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    @if ($attributes->has('title'))
        <title>{{ $attributes->get('title') }} | {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
</head>

<body class="flex flex-col min-h-screen">

    {{-- include header --}}
    @include('layouts.header')

    {{-- page content --}}
    <main class="{{ $attributes->get('class') ?? 'flex-auto container mx-auto px-3 md:px-0' }}"">
        {{ $slot }}
    </main>

    {{-- include footer --}}
    @include('layouts.footer')

</body>

</html>
