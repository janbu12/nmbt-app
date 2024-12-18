<div class="flex px-10 py-3 drop-shadow-md w-full justify-between text-tertiery1 bg-white">
    <a href="/" class="flex items-center gap-3 hover:text-secondary1">
        <img src="images/Logo.png" alt="logo.png" class="lg:max-w-12">
        <h1 class="font-medium">Nordic Mountain Bound Travelers</h1>
    </a>
    <div class="flex items-center gap-14">
        <x-navbar.link href="/">Beranda</x-navbar.link>
        <x-navbar.link href="/sewa">Sewa</x-navbar.link>
        <x-navbar.link href="/about">Tentang Kami</x-navbar.link>
        @auth
            <x-button as="a">Auth</x-button>
        @else
            <x-button as="a" href="/login">Login</x-button>
        @endauth
    </div>
</div>
