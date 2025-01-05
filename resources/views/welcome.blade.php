<x-app-layout title="Beranda" :navbar-variant="'transparent'">
    <div id="main-background" class="relative">
        <img src="{{ asset('images/landing-page.png') }}" alt="landing-page.png" class="h-screen w-full object-cover">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <h1 class="text-bg3 text-7xl font-medium text-center">NMBT</h1>
            <h1 class="text-bg3 text-3xl font-medium text-center">Nordic Mountain Bound Travelers</h1>
        </div>
    </div>
    <div class="flex flex-col text-tertiery1">

        <div class="px-12 h-screen flex flex-col items-center justify-center">
            {{-- Carousel Section --}}
            <div class="relative w-full lg:w-3/4 overflow-hidden">
                <!-- Slides Wrapper -->
                <div id="carousel-slides" class="flex transition-transform duration-700 ease-in-out">
                    <!-- Slide 1 -->
                    <div class="flex-shrink-0 w-full grid grid-cols-4">
                        <img src="{{ asset('images/sliders/camp1.png') }}" alt="Camp 1" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp2.png') }}" alt="Camp 2" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp3.png') }}" alt="Camp 3" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp4.png') }}" alt="Camp 4" class="w-full h-auto shadow-lg" />
                    </div>
                    <!-- Slide 2 -->
                    <div class="flex-shrink-0 w-full grid grid-cols-4">
                        <img src="{{ asset('images/sliders/camp1.png') }}" alt="Camp 5" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp2.png') }}" alt="Camp 6" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp3.png') }}" alt="Camp 7" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp4.png') }}" alt="Camp 8" class="w-full h-auto shadow-lg" />
                    </div>
                    <div class="flex-shrink-0 w-full grid grid-cols-4">
                        <img src="{{ asset('images/sliders/camp1.png') }}" alt="Camp 9" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp2.png') }}" alt="Camp 10" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp3.png') }}" alt="Camp 11" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp4.png') }}" alt="Camp 12" class="w-full h-auto shadow-lg" />
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button id="prevBtn" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-700 hover:bg-gray-600 text-white p-2 rounded shadow-lg">
                    &#10094;
                </button>
                <button id="nextBtn" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-700 hover:bg-gray-600 text-white p-2 rounded shadow-lg">
                    &#10095;
                </button>

                <!-- Pagination Dots -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button class="dot w-3 h-3 bg-gray-100 border-none hover:bg-gray-400 rounded-full"></button>
                    <button class="dot w-3 h-3 bg-gray-100 border-none hover:bg-gray-400 rounded-full"></button>
                    <button class="dot w-3 h-3 bg-gray-100 border-none hover:bg-gray-400 rounded-full"></button>
                </div>
            </div>
            <p class="text-center text-2xl lg:max-w-[500px] mt-20">
                Menyediakan semua kebutuhan camping yang anda butuhkan kapanpun yang anda inginkan
            </p>
        </div>
        <div class="px-12 flex flex-col min-h-screen bg-tertiery3 justify-center items-center gap-8">
            <h2 class="lg:text-3xl font-medium">Top 3 Products</h2>
            <div class="flex gap-5">
                @foreach($topThreeProducts as $product)
                    <a href="{{ route('products.show', $product['product']->id) }}" class="card bg-white w-full md:w-80 xl:w-1/3 2xl:w-96 max-xl: h-auto shadow-lg drop-shadow cursor-pointer hover:scale-90 transition group">
                        <figure>
                            @if ($topThreeProducts[1]['product']->images->isNotEmpty())
                                <div class="lg:h-48 lg:h-62">
                                    <img src="{{ asset('storage/' . $topThreeProducts[1]['product']->images->first()->image_path) }}" alt="Product Image" class="w-full h-full object-cover"/>
                                </div>
                            @else
                                <div class="lg:h-48 lg:h-62">
                                    <img
                                        src="{{ asset('images/produk-icon-dummy.png') }}"
                                        alt="Shoes"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            @endif
                        </figure>
                        <div class="card-body text-tertiery1">
                            <h2 class="card-title lg:text-base">{{ $product['product']->name }}</h2>
                            <p class="lg:text-sm 2xl:text-base">{{ $product['product']->teaser }}</p>
                            <div class="flex items-center gap-2">
                                <div class="flex space-x-1 lg:text-xl 2xl:text-3xl">
                                    @php $averageRatingProduct = round($product['average_rating']); @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRatingProduct)
                                            <span class="text-yellow-500 }}">&#9733;</span>
                                        @else
                                            <span class="text-gray-300 }}">&#9733;</span>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm">{{number_format($product['average_rating'],1)}}</span>
                            </div>
                            <div class="flex flex-col items-end gap-2 mt-2">
                                <span class="2xl:text-md lg:text-sm">
                                    Total Sales {{ $product['total_sales'] }}
                                </span>
                                <span class="font-medium lg:text-lg 2xl:text-2xl">
                                    Rp. {{ number_format($product['product']->price ?? 0, 2, ',', '.') }}
                                </span>
                                <div class="card-actions justify-end">
                                    <div class="badge badge-outline 2xl:text-sm lg:text-xs" >
                                        {{ $product['product']->category->category_name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slides = document.getElementById('carousel-slides');
                const dots = document.querySelectorAll('.dot');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');

                let currentIndex = 0;
                const totalSlides = slides.children.length;

                function updateCarousel() {
                    const offset = -currentIndex * 100; // Geser slide berdasarkan indeks
                    slides.style.transform = `translateX(${offset}%)`;

                    // Update active dot
                    dots.forEach((dot, index) => {
                        if (index === currentIndex) {
                            dot.classList.add('bg-gray-700', 'border', 'hover:bg-gray-600', 'border-secondary1');
                            dot.classList.remove('bg-gray-100', 'border-none', 'hover:bg-gray-400');
                        } else {
                            dot.classList.add('bg-gray-100', 'border-none', 'hover:bg-gray-400');
                            dot.classList.remove('bg-gray-700', 'border', 'hover:bg-gray-600', 'border-secondary1');
                        }
                    });
                }

                function showNextSlide() {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateCarousel();
                }

                function showPrevSlide() {
                    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                    updateCarousel();
                }

                // Event Listeners
                nextBtn.addEventListener('click', showNextSlide);
                prevBtn.addEventListener('click', showPrevSlide);

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        currentIndex = index;
                        updateCarousel();
                    });
                });

                // Auto-play functionality
                updateCarousel();
                setInterval(showNextSlide, 5000); // Pindah slide setiap 5 detik
            });

            document.addEventListener('DOMContentLoaded', () => {
                const navbar = document.getElementById('navbar');
                const navbarLinks = document.querySelectorAll('.nav-link');
                const loginBtn = document.getElementById('login-btn');
                const mainBackground = document.getElementById('main-background');
                const transparentClasses = 'bg-transparent text-white';
                const blackClasses = 'bg-white text-tertiery1';
                const transparentLinkClasses = 'text-white hover:text-gray-300';
                const blackLinkClasses = 'text-tertiery1 hover:text-tertiery1';

                function handleScroll() {
                    const mainBackgroundHeight = mainBackground.offsetHeight;
                    const scrollY = window.scrollY;

                    if (scrollY >= mainBackgroundHeight) {
                        // Ubah navbar menjadi transparent-black
                        navbar.classList.remove(...transparentClasses.split(' '));
                        navbar.classList.add(...blackClasses.split(' '));

                        // Ubah navbar link
                        navbarLinks.forEach(link => {
                            link.classList.remove(...transparentLinkClasses.split(' '));
                            link.classList.add(...blackLinkClasses.split(' '));
                        });

                        // Ubah login button
                        loginBtn.classList.remove('btn-tertiery-custom');
                        loginBtn.classList.add('btn-secondary-custom');
                    } else {
                        // Reset navbar ke transparent
                        navbar.classList.remove(...blackClasses.split(' '));
                        navbar.classList.add(...transparentClasses.split(' '));

                        // Ubah login button
                        navbarLinks.forEach(link => {
                            link.classList.remove(...blackLinkClasses.split(' '));
                            link.classList.add(...transparentLinkClasses.split(' '));
                        });

                        // Ubah login button

                        loginBtn.classList.remove('btn-secondary-custom');
                        loginBtn.classList.add('btn-tertiery-custom');
                    }
                }

                // Event listener untuk scroll
                window.addEventListener('scroll', handleScroll);

                // Panggil saat halaman pertama kali dimuat
                handleScroll();
            });
        </script>
    </x-slot>
</x-app-layout>
