<x-app-layout title="Beranda" :navbar-variant="'transparent'">
    <div class="relative">
        <img src="{{ asset('images/landing-page.png') }}" alt="landing-page.png" class="h-screen w-full object-cover">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <h1 class="text-bg3 text-7xl font-medium text-center">NMBT</h1>
            <h1 class="text-bg3 text-3xl font-medium text-center">Nordic Mountain Bound Travelers</h1>
        </div>
    </div>
    <div class="px-12 flex flex-col text-tertiery1">

        {{-- Carousel Section --}}
        <div class="py-16 flex flex-col items-center">
            <p class="text-center text-2xl lg:max-w-[500px]">
                Menyediakan semua kebutuhan camping yang anda butuhkan kapanpun yang anda inginkan
            </p>
        </div>

    </div>
</x-app-layout>
