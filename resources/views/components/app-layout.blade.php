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

        <style>
            .loader {
                border-top-color: transparent; /* Warna bagian atas spinner */
            }
        </style>

    </head>
    <body class="flex flex-col {{$bodyClass ?? ''}}" x-data>
        @if(!request()->is('login') && !request()->is('register') && !request()->is('cart/invoice') && !request()->is('forgot-password') && !request()->is('password*'))
            @include('components.navbar.index', ['variant' => $navbarVariant ?? 'default'])
        @endif

        <div x-show="$store.loadingState.isLoading" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-[999]">
            <div class="loader border-t-transparent border-solid rounded-full w-16 h-16 border-4 border-blue-500 animate-spin"></div>
        </div>

        {{$slot}}

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('loadingState', {
                    isLoading: false,
                    showLoading() {
                        this.isLoading = true;
                    },
                    hideLoading() {
                        this.isLoading = false;
                    },
                });
            });
        </script>

        @isset($scripts)
            {{ $scripts }}
        @endisset
    </body>

</html>
