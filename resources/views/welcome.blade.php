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
            <div class="relative w-full lg:w-3/4 overflow-hidden" id="carousel-container">
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
                    <div class="flex-shrink-0 w-full grid grid-cols-4 opacity-75">
                        <img src="{{ asset('images/sliders/camp5.webp') }}" alt="Camp 5" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp6.webp') }}" alt="Camp 6" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp7.webp') }}" alt="Camp 7" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp8.webp') }}" alt="Camp 8" class="w-full h-auto shadow-lg" />
                    </div>
                    <div class="flex-shrink-0 w-full grid grid-cols-4 opacity-75">
                        <img src="{{ asset('images/sliders/camp9.webp') }}" alt="Camp 9" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp10.webp') }}" alt="Camp 10" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp11.webp') }}" alt="Camp 11" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp12.webp') }}" alt="Camp 12" class="w-full h-auto shadow-lg" />
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

        {{-- Section Top 3 Products --}}
        <div class="px-12 flex flex-col min-h-screen bg-tertiery3 py-12 lg:py-0 justify-center items-center gap-8">
            <h2 class="text-3xl font-medium">Top 3 Products</h2>
            <div class="flex flex-wrap lg:flex-nowrap items-center justify-center gap-5">
                @foreach($topThreeProducts as $index => $product)
                    <a href="{{ route('products.show', $product['product']->id) }}" class="card bg-white w-full md:w-80 max-xl: h-auto shadow-lg drop-shadow cursor-pointer hover:scale-90 transition group">
                        <figure>
                            @if ($topThreeProducts[$index]['product']->images->isNotEmpty())
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

        {{-- Section Moments --}}
        <div class="px-12 flex flex-col min-h-screen justify-center items-center gap-8 py-12 lg:py-0">
            <h2 class="text-3xl font-medium">Buat Moment Anda</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <!-- Card 1 -->
                <div class="bg-white shadow-lg rounded-lg p-4 max-w-xs">
                    <img src="{{ asset('images/moments/moment1.webp') }}" alt="Moment 1" class="w-full h-48 object-cover rounded-t-lg">
                    <p class="mt-4 text-center">"Layanan NMBT membantu! Semua perlengkapannya berkualitas dan terawat."</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white shadow-lg rounded-lg p-4 max-w-xs">
                    <img src="{{ asset('images/moments/moment2.webp') }}" alt="Moment 2" class="w-full h-48 object-cover rounded-t-lg">
                    <p class="mt-4 text-center">"Nikmati layanan NMBT, Penyediaan perlengkapan berkemah untuk orang-orang terdekat anda."</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white shadow-lg rounded-lg p-4 max-w-xs">
                    <img src="{{ asset('images/moments/moment3.webp') }}" alt="Moment 3" class="w-full h-48 object-cover rounded-t-lg">
                    <p class="mt-4 text-center">"Memberikan solusi mudah bagi para petualang untuk mengakses peralatan camping dengan kualitas terbaik dan harga terjangkau."</p>
                </div>
            </div>
            <x-button as="a" href="{{ route('products.index') }}" variant="secondary" class="text-xs lg:text-base">Lihat Semua Produk Kami</x-button>
        </div>

        {{-- Section Kata kata hari ini --}}
        <div class="px-12 flex min-h-screen lg:min-h-fit lg:py-28 justify-center items-center bg-tertiery3">
            <h2 class="text-center text-lg lg:text-4xl font-medium max-w-2xl lg:max-w-4xl leading-relaxed">"Kami percaya bahwa setiap perjalanan adalah awal dari petualangan yang tak terlupakan. NMBT hadir untuk menyediakan peralatan camping berkualitas, sehingga Anda bisa menikmati keindahan alam dengan nyaman dan aman."</h2>
        </div>

        {{-- Section Tentang Kami --}}
        <div id="about" class="px-12 flex flex-col min-h-screen justify-center items-center gap-8 my-20 scroll-mt-32">
            <h2 class="text-3xl font-medium text-center">Tentang Kami</h2>
            <div class="max-w-xs">
                <img src="{{ asset('images/about-us.webp') }}" alt="About Us" class="w-full h-full object-cover rounded-lg">
            </div>

            <p class="text-center text-lg max-w-2xl leading-relaxed">
                NMBT (Nordic Mountain Bound Travelers) adalah penyedia peralatan camping berkualitas yang berkomitmen untuk membantu Anda menikmati keindahan alam dengan nyaman dan aman. Kami percaya bahwa setiap perjalanan adalah awal dari petualangan yang tak terlupakan. Dengan berbagai pilihan perlengkapan camping yang kami tawarkan, Anda dapat menjelajahi alam bebas tanpa khawatir tentang perlengkapan yang Anda butuhkan.
            </p>
            <p class="text-center text-lg max-w-2xl leading-relaxed">
                Tim kami terdiri dari para pecinta alam yang berpengalaman, siap memberikan solusi terbaik untuk kebutuhan camping Anda. Bergabunglah dengan kami dan ciptakan momen tak terlupakan di alam terbuka!
            </p>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto flex flex-wrap lg:flex-nowrap gap-4 lg:gap-0 justify-between items-center px-12">
            <div>
                <h1 class="text-4xl font-bold">NMBT</h1>
                <p class="text-lg">Nordic Mountain Bound Travelers</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Contact us</h3>
                <p class="mt-2">
                    <a href="https://instagram.com/nmbt.survival" class="hover:underline flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                        @nmbt.survival
                    </a>
                </p>
                <p class="mt-1">
                    <a href="https://facebook.com/nmbt.survival" class="hover:underline flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>
                        @nmbt.survival
                    </a>
                </p>
                <p class="mt-1">
                    <a href="https://wa.me/628xxxxxxxxxxx" class="hover:underline flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                        </svg>
                        08xxxxxxxxxxxx
                    </a>
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Quick link</h3>
                <ul class="mt-2">
                    <li><a href="/#" class="hover:underline">Beranda</a></li>
                    <li><a href="/#about" class="hover:underline">About us</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:underline">Sewa</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slides = document.getElementById('carousel-slides');
                const dots = document.querySelectorAll('.dot');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const carouselContainer = document.getElementById('carousel-container');

                let currentIndex = 0;
                const totalSlides = slides.children.length;
                let slideInterval;

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

                function startAutoSlide() {
                    console.log('start');
                    slideInterval = setInterval(showNextSlide, 5000); // Pindah slide setiap 5 detik
                }

                function stopAutoSlide() {
                    console.log('stop');
                    clearInterval(slideInterval);
                }

                // Event Listeners
                nextBtn.addEventListener('click', () => {
                    showNextSlide();
                    stopAutoSlide();
                    startAutoSlide();
                });

                prevBtn.addEventListener('click', () => {
                    showPrevSlide();
                    stopAutoSlide();
                    startAutoSlide();
                });

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        currentIndex = index;
                        updateCarousel();
                        stopAutoSlide();
                        startAutoSlide();
                    });
                });

                // Auto-play functionality
                updateCarousel();
                startAutoSlide();
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
