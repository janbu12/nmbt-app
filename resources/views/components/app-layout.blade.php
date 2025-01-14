<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">

        <title>
            @isset($title)
                {{ $title }} - NMBT
            @else
                Laravel
            @endisset
        </title>


        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

    </head>
    <body class="flex flex-col {{$bodyClass ?? ''}}">
        @if(!request()->is('login') && !request()->is('register') && !request()->is('cart/checkout'))
            @include('components.navbar.index', ['variant' => $navbarVariant ?? 'default'])
        @endif

        {{$slot}}
    </body>

    @isset($scripts)
        {{ $scripts }}
    @endisset
</html>
