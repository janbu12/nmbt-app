<div class="flex px-10 py-3 drop-shadow-md w-full justify-between text-tertiery1 bg-white">
    <a href="{{Auth::user() && Auth::user()->role === 'admin' ? '/admin/dashboard':'/' }}" class="flex items-center gap-3 hover:text-secondary1">
        <img src="{{asset('images/Logo.png')}}" alt="logo.png" class="lg:max-w-12">
        <h1 class="font-medium">Nordic Mountain Bound Travelers</h1>
    </a>
    <div class="flex items-center gap-14">
        {{-- Navbar Link --}}
        @if (Auth::user() && Auth::user()->role === 'admin')
            <x-navbar.link href="/admin/dashboard">Dasboard</x-navbar.link>

        @else
            <x-navbar.link href="/">Beranda</x-navbar.link>
            <x-navbar.link href="/sewa">Sewa</x-navbar.link>
            <x-navbar.link href="/about">Tentang Kami</x-navbar.link>
        @endif
        @auth
            <div class="relative" x-data="{ open: false }">
                <!-- Button -->
                <x-button
                    class="px-3 w-12 group hover:bg-bg1 hover:border-bg1 transition-all duration-300"
                    @click="open = !open"
                    @click.outside="open = false"
                >
                    <div class="flex items-center gap-2">
                        <svg class="lg:w-8 fill-tertiery1 transition-colors duration-300" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25 0C18.8911 0 13.8891 5.00208 13.8891 11.1109C13.8891 17.2203 18.8911 22.2224 25 22.2224C31.1089 22.2224 36.1109 17.2203 36.1109 11.1109C36.1109 5.00208 31.1089 0 25 0ZM25 5.55573C28.1031 5.55573 30.5557 8.00781 30.5557 11.1109C30.5557 14.2146 28.1031 16.6667 25 16.6667C21.8969 16.6667 19.4443 14.2146 19.4443 11.1109C19.4443 8.00781 21.8969 5.55573 25 5.55573ZM25 30.5557C20.1495 30.5557 14.4099 31.6948 9.58125 33.5938C7.1724 34.5484 4.98073 35.688 3.23333 37.1422C1.4974 38.5849 0 40.549 0 43.0557V50H50V43.0557C50 40.549 48.5026 38.5849 46.7557 37.1422C45.0193 35.688 42.8276 34.5484 40.4188 33.5938C35.5901 31.6948 29.8505 30.5557 25 30.5557ZM25 36.1109C28.9281 36.1109 34.299 37.1526 38.3786 38.7589C40.4297 39.5724 42.1547 40.538 43.2073 41.4062C44.2599 42.2745 44.4443 42.8714 44.4443 43.0557V44.4443H5.55573V43.0557C5.55573 42.8714 5.7401 42.2745 6.79271 41.4062C7.84531 40.538 9.57031 39.5724 11.6104 38.7589C15.701 37.1526 21.0719 36.1109 25 36.1109Z" fill="current"/>
                        </svg>
                    </div>
                </x-button>

                <!-- Flying Menu -->
                <div
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                    x-show="open"
                    x-transition
                >
                    <ul class="py-2 text-sm text-gray-700">
                        @if (Auth::check() && !Auth::user()->role === 'admin')
                            <li>
                                <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            </li>
                            <li>
                                <a href="/cart" class="block px-4 py-2 hover:bg-gray-100">Cart</a>
                            </li>
                            <li>
                                <a href="/history" class="block px-4 py-2 hover:bg-gray-100">History</a>
                            </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <x-button as="a" href="/login">Login</x-button>
        @endauth
    </div>
</div>
