<div
    id="navbar"
    class="fixed px-4 md:px-10 py-3 drop-shadow-md w-full z-50 {{ $variant === "transparent" ? 'bg-transparent text-white fixed backdrop-blur-sm' : 'bg-white text-tertiery1 md:relative'}}"
>
    <div
        class="flex justify-between">
        <a href="{{Auth::user() && Auth::user()->role === 'admin' ? '/admin/dashboard':'/' }}" class="flex items-center gap-3 {{ $variant === "transparent" ? 'hover:text-gray-300 hover:scale-105' : 'hover:text-secondary1'}}  transition-all duration-300">
            <img src="{{asset('images/Logo.png')}}" alt="logo.png" class="max-w-12">
            <h1 class="font-medium">Nordic Mountain Bound Travelers</h1>
        </a>
        <div id="navbar-links" class="items-center gap-14 hidden lg:flex">
            {{-- Navbar Link --}}
            @if (Auth::user() && Auth::user()->role === 'admin')
            <x-navbar.link href="/admin/dashboard">Dashboard</x-navbar.link>
            <x-navbar.link href="/products">Items</x-navbar.link>
            <x-navbar.link href="/admin/users">Users</x-navbar.link>
            <x-navbar.link href="/admin/history">History</x-navbar.link>
            @else
            <x-navbar.link href="/#" :variant="$variant" data-hash="#" :loading="$variant == 'transparent' ? 'none' : 'default'">Home</x-navbar.link>
            <x-navbar.link href="/#about" :variant="$variant" data-hash="#about" :loading="$variant == 'transparent' ? 'none' : 'default'">About Us</x-navbar.link>
            <x-navbar.link href="/products" :variant="$variant">Rent</x-navbar.link>

            @endif

            @if (!auth()->user())
                @if ($variant === "transparent")
                    <x-button as="a" href="/login" variant="tertiery" id="login-btn">Login</x-button>
                @else
                    <x-button as="a" href="/login">Login</x-button>
                @endif
            @endif
        </div>
        <!-- Toggle Button for Mobile -->
        <div class="lg:hidden flex items-center justify-center">
            <button id="mobile-menu-toggle" class="{{ $variant === "transparent" ? 'text-white hover:bg-gray-950 hover:bg-opacity-30' : 'text-tertiery1'}} focus:outline-none p-2 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        @auth
            <div class="dropdown dropdown-end group/userInfo hidden lg:flex">
                <div tabindex="0" role="button" class="avatar flex items-center gap-4">
                    <h1 class="font-medium group-hover/userInfo:text-secondary1">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</h1>
                    <div class="w-12 rounded-full bg-secondary1">
                    @if (auth()->user()->imageUser)
                        <img
                            class="rounded-full group-hover/userInfo:scale-90 transition-all duration-300"
                            alt="user.png"
                            src="{{ asset('storage/' . Auth::user()->imageUser) }}" />
                    @else
                        <img
                            class="rounded-full group-hover/userInfo:scale-90 transition-all duration-300"
                            alt="user.png"
                            src="{{asset('images/boy.png')}}" />
                    @endif
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[50] mt-14 w-52 p-3 shadow text-tertiery1">
                    @if (Auth::user()->role !== 'admin')
                        <li>
                            <a
                                href="/user/profile" class="block px-4 py-2 hover:bg-gray-100"
                                @click="Alpine.store('loadingState').showLoading();"
                            >
                                Profile
                            </a>
                        </li>
                        <li>
                            <a
                                href="/cart"
                                class="flex px-4 py-2 hover:bg-gray-100 justify-between"
                                @click="Alpine.store('loadingState').showLoading();"
                            >
                                Cart
                                <span class="badge bg-secondary3 text-bg3">{{ auth()->user()->cart->count() }}</span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="/user/history?status=done"
                                class="flex px-4 py-2 hover:bg-gray-100 justify-between"
                                @click="Alpine.store('loadingState').showLoading();"
                            >
                                Your Orders
                                <span class="badge bg-secondary3 text-bg3">{{ auth()->user()->rent->count() }}</span>
                            </a>
                        </li>
                    @endif
                    <form method="POST" action="{{ route('auth.logout') }}" class="block">
                        @csrf
                        <button @click="Alpine.store('loadingState').showLoading();" type="submit" class="w-full text-start  px-4 py-2 hover:bg-gray-100 rounded-lg">Logout</button>
                    </form>
                </ul>
            </div>
        @endauth
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden py-5">
        <div class="flex flex-col items-center gap-6 mt-4">
            @if (Auth::user() && Auth::user()->role === 'admin')
                <x-navbar.link href="/admin/dashboard">Dasboard</x-navbar.link>
                <x-navbar.link href="/admin/item">Items</x-navbar.link>
                <x-navbar.link href="/admin/history">History</x-navbar.link>
            @else
                <x-navbar.link href="/#" :variant="$variant" data-hash="#" :loading="$variant == 'transparent' ? 'none' : 'default'">Home</x-navbar.link>
                <x-navbar.link href="/#about" :variant="$variant" data-hash="#about" :loading="$variant == 'transparent' ? 'none' : 'default'">Abount Us</x-navbar.link>
                <x-navbar.link href="/products" :variant="$variant">Rent</x-navbar.link>
            @endif

            @if (!auth()->user())
                <x-button as="a" href="/login" variant="tertiery" id="login-btn">Login</x-button>
            @endif

            @auth
                @if (Auth::user()->role !== 'admin')
                    <div class="border w-full opacity-50"></div>
                    <x-navbar.link href="/cart" :variant="$variant">
                        Cart
                        <span class="badge bg-secondary3 text-bg3">{{ auth()->user()->cart->count() }}</span>
                    </x-navbar.link>
                    <x-navbar.link href="/history" :variant="$variant">
                        Your Orders
                        <span class="badge bg-secondary3 text-bg3">{{ auth()->user()->rent->count() }}</span>
                    </x-navbar.link>
                @endif
                <a href="/user/profile" class="avatar flex items-center gap-4">
                    <h1 class="font-medium group-hover/userInfo:text-secondary1">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</h1>
                    <div class="w-12 rounded-full bg-secondary1">
                    @if (auth()->user()->imageUser)
                        <img
                            class="rounded-full group-hover/userInfo:scale-90 transition-all duration-300"
                            alt="user.png"
                            src="{{ asset('storage/' . Auth::user()->imageUser) }}" />
                    @else
                        <img
                            class="rounded-full group-hover/userInfo:scale-90 transition-all duration-300"
                            alt="user.png"
                            src="{{asset('images/boy.png')}}" />
                    @endif
                    </div>
                </a>
                <form method="POST" action="{{ route('auth.logout') }}" class="block">
                    @csrf
                    <x-button type="submit"
                    :variant="$variant == 'transparent' ? 'tertiery' : 'secondary'"
                      @click="Alpine.store('loadingState').showLoading();"
                    >
                        Logout
                    </x-button>
                </form>
            @endauth
        </div>
    </div>
</div>

<script>
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>
