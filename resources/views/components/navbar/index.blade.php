<div class="flex px-10 py-3 drop-shadow-md w-full justify-between text-tertiery1 bg-white">
    <a href="{{Auth::user() && Auth::user()->role === 'admin' ? '/admin/dashboard':'/' }}" class="flex items-center gap-3 hover:text-secondary1 transition-all duration-300">
        <img src="{{asset('images/Logo.png')}}" alt="logo.png" class="lg:max-w-12">
        <h1 class="font-medium">Nordic Mountain Bound Travelers</h1>
    </a>
    <div class="flex items-center gap-14">
        {{-- Navbar Link --}}
        <x-navbar.link href="/">Beranda</x-navbar.link>
        <x-navbar.link href="/sewa">Sewa</x-navbar.link>
        <x-navbar.link href="/about">Tentang Kami</x-navbar.link>
        @if (Auth::user() && Auth::user()->role === 'admin')
            <x-navbar.link href="/admin/dashboard">Dasboard</x-navbar.link>
        @endif

        @if (!auth()->user())
            <x-button as="a" href="/login">Login</x-button>
        @endif

    </div>
    @auth
    <div class="flex gap-4">
        <div class="flex items-center gap-4">
            <h1 class="font-medium">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</h1>
            <details class="dropdown dropdown-end">
                <summary tabindex="0" role="button" class="btn btn-ghost btn-circle avatar group">
                    <div class="w-12 rounded-full">
                    <img
                        class="rounded-full group-hover:scale-90 transition-all duration-300"
                        alt="user.png"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </summary>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-4 w-52 p-3 shadow">
                    @if (Auth::user()->role !== 'admin')
                        <li>
                            <a href="/user/profile" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        </li>
                        <li>
                            <a href="/cart" class="flex px-4 py-2 hover:bg-gray-100 justify-between">
                                Cart
                                <span class="badge bg-secondary3 text-bg3">8</span>
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
        </details>
    </div>
    @endauth
</div>
