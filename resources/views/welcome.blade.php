<x-app-layout title="Beranda" :navbar-variant="'transparent'">
    <div id="main-background" class="relative">
        <img src="{{ asset('images/landing-page.png') }}" alt="landing-page.png" class="h-screen w-full object-cover">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <h1 class="text-bg3 text-7xl font-medium text-center">NMBT</h1>
            <h1 class="text-bg3 text-3xl font-medium text-center">Nordic Mountain Bound Travelers</h1>
        </div>
    </div>
    <div class="px-12 flex flex-col text-tertiery1">

        <div class="h-screen flex flex-col items-center justify-center">
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
                        <img src="{{ asset('images/sliders/camp5.png') }}" alt="Camp 5" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp6.png') }}" alt="Camp 6" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp7.png') }}" alt="Camp 7" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp8.png') }}" alt="Camp 8" class="w-full h-auto shadow-lg" />
                    </div>
                    <div class="flex-shrink-0 w-full grid grid-cols-4">
                        <img src="{{ asset('images/sliders/camp9.png') }}" alt="Camp 9" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp10.png') }}" alt="Camp 10" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp11.png') }}" alt="Camp 11" class="w-full h-auto shadow-lg" />
                        <img src="{{ asset('images/sliders/camp12.png') }}" alt="Camp 12" class="w-full h-auto shadow-lg" />
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button id="prevBtn" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-700 text-white p-2 rounded-full shadow-lg">
                    &#10094;
                </button>
                <button id="nextBtn" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-700 text-white p-2 rounded-full shadow-lg">
                    &#10095;
                </button>

                <!-- Pagination Dots -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button class="dot w-3 h-3 bg-gray-300 rounded-full"></button>
                    <button class="dot w-3 h-3 bg-gray-300 rounded-full"></button>
                    <button class="dot w-3 h-3 bg-gray-300 rounded-full"></button>
                </div>
            </div>
            <p class="text-center text-2xl lg:max-w-[500px] mt-20">
                Menyediakan semua kebutuhan camping yang anda butuhkan kapanpun yang anda inginkan
            </p>
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
                        dot.classList.toggle('bg-gray-700', index === currentIndex);
                        dot.classList.toggle('bg-gray-300', index !== currentIndex);
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
                const navbarLinks = document.querySelectorAll('#navbar-links a');
                const mainBackground = document.getElementById('main-background');
                const transparentClasses = 'bg-transparent text-white';
                const blackClasses = 'bg-white text-tertiery1';
                const transparentLinkClasses = 'text-white hover:text-gray-300';
                const blackLinkClasses = 'text-tertiery1 hover:text-tertiery1';

                console.log(navbarLinks);

                function handleScroll() {
                    const mainBackgroundHeight = mainBackground.offsetHeight;
                    const scrollY = window.scrollY;

                    if (scrollY >= mainBackgroundHeight) {
                        // Ubah navbar menjadi transparent-black
                        navbar.classList.remove(...transparentClasses.split(' '));
                        navbar.classList.add(...blackClasses.split(' '));

                        navbarLinks.forEach(link => {
                            link.classList.remove(...transparentLinkClasses.split(' '));
                            link.classList.add(...blackLinkClasses.split(' '));
                        });
                    } else {
                        // Reset navbar ke transparent
                        navbar.classList.remove(...blackClasses.split(' '));
                        navbar.classList.add(...transparentClasses.split(' '));

                        navbarLinks.forEach(link => {
                            link.classList.remove(...blackLinkClasses.split(' '));
                            link.classList.add(...transparentLinkClasses.split(' '));
                        });
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
