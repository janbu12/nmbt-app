// carousel.js

document.addEventListener('DOMContentLoaded', () => {
    initializeCarousel();
});

function initializeCarousel() {
    const slides = document.getElementById('carousel-slides');
    const dotsContainer = document.getElementById('pagination-dots');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (!slides) {
        return;
    }

    let currentIndex = 0;
    let totalSlides = Math.ceil(slides.children.length / (window.innerWidth >= 1024 ? 4 : 1));
    let slideInterval;

    function updateDots() {
        dotsContainer.innerHTML = '';
        let numberOfDots = window.innerWidth < 1024 ? Math.ceil(slides.children.length) : Math.ceil(slides.children.length / 4);

        for (let i = 0; i < numberOfDots; i++) {
            const dot = document.createElement('button');
            dot.className = 'dot w-3 h-3 bg-gray-100 border-none hover:bg-gray-400 rounded-full';
            dot.addEventListener('click', () => {
                currentIndex = i;
                updateCarousel();
                stopAutoSlide();
                startAutoSlide();
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateCarousel() {
        const offset = -currentIndex * (window.innerWidth >= 1024 ? 100 : 100);
        slides.style.transform = `translateX(${offset}%)`;

        const dots = dotsContainer.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-gray-700', index === currentIndex);
            dot.classList.toggle('bg-gray-100', index !== currentIndex);
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
        slideInterval = setInterval(showNextSlide, 3500);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

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

    updateDots();
    updateCarousel();
    startAutoSlide();

    window.addEventListener('resize', () => {
        totalSlides = Math.ceil(slides.children.length / (window.innerWidth >= 1024 ? 4 : 1));
        updateDots();
        updateCarousel();
    });
}
