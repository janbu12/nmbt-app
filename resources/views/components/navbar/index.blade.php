<div
    id="navbar"
    class="flex px-10 py-3 drop-shadow-md w-full justify-between z-50 {{ $variant === "transparent" ? 'bg-transparent text-white fixed' : 'bg-white text-tertiery1'}}">
    <a href="{{Auth::user() && Auth::user()->role === 'admin' ? '/admin/dashboard':'/' }}" class="flex items-center gap-3 {{ $variant === "transparent" ? 'hover:text-gray-300 hover:scale-105' : 'hover:text-secondary1'}}  transition-all duration-300">
        <img src="{{asset('images/Logo.png')}}" alt="logo.png" class="lg:max-w-12">
        <h1 class="font-medium">Nordic Mountain Bound Travelers</h1>
    </a>
    <div id="navbar-links" class="flex items-center gap-14">
        {{-- Navbar Link --}}
        @if (Auth::user() && Auth::user()->role === 'admin')
        <x-navbar.link href="/admin/dashboard">Dasboard</x-navbar.link>
        <x-navbar.link href="/admin/item">Item</x-navbar.link>
        <x-navbar.link href="/admin/history">Riwayat</x-navbar.link>
        @else
        <x-navbar.link href="/" :variant="$variant">Beranda</x-navbar.link>
        <x-navbar.link href="/products" :variant="$variant">Sewa</x-navbar.link>
        <x-navbar.link href="/about" :variant="$variant">Tentang Kami</x-navbar.link>

        @endif

        @if (!auth()->user())
            @if ($variant === "transparent")
                <x-button as="a" href="/login" variant="tertiery">Login</x-button>
            @else
                <x-button as="a" href="/login">Login</x-button>
            @endif
        @endif

    </div>
    @auth
        <div class="dropdown dropdown-end group/userInfo">
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
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-4 w-52 p-3 shadow text-tertiery1">
                @if (Auth::user()->role !== 'admin')
                    <li>
                        <a href="/user/profile" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    </li>
                    <li>
                        <a href="/cart" class="flex px-4 py-2 hover:bg-gray-100 justify-between">
                            Cart
                            <span class="badge bg-secondary3 text-bg3">{{ auth()->user()->cart->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/history" class="block px-4 py-2 hover:bg-gray-100">History</a>
                    </li>
                @endif
                <form method="POST" action="{{ route('auth.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-start  px-4 py-2 hover:bg-gray-100 rounded-lg">Logout</button>
                </form>
            </ul>
        </div>
    @endauth
</div>
