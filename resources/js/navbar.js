// navbar.js

document.addEventListener('DOMContentLoaded', () => {
    initializeNavbar();
});

function initializeNavbar() {
    const navbar = document.getElementById('navbar');
    const navbarLinks = document.querySelectorAll('.nav-link');
    const loginBtn = document.getElementById('login-btn');
    const mainBackground = document.getElementById('main-background');
    const toggleMenu = document.getElementById('mobile-menu-toggle');
    const transparentClasses = 'bg-transparent text-white';
    const blackClasses = 'bg-white text-tertiery1';
    const transparentLinkClasses = 'text-white hover:text-gray-300';
    const blackLinkClasses = 'text-tertiery1 hover:text-tertiery1';

    if (!navbar || !mainBackground) {
        return; // Keluar dari fungsi jika elemen tidak ada
    }

    function handleScroll() {
        const mainBackgroundHeight = mainBackground.offsetHeight;
        const scrollY = window.scrollY;

        if (scrollY >= mainBackgroundHeight) {
            navbar.classList.remove(...transparentClasses.split(' '));
            navbar.classList.add(...blackClasses.split(' '));

            navbarLinks.forEach(link => {
                link.classList.remove(...transparentLinkClasses.split(' '));
                link.classList.add(...blackLinkClasses.split(' '));
            });

            toggleMenu.classList.remove('text-white');
            toggleMenu.classList.add('text-tertiery1');

            if (loginBtn) {
                loginBtn.classList.remove('btn-tertiery-custom');
                loginBtn.classList.add('btn-secondary-custom');
            }
        } else {
            navbar.classList.remove(...blackClasses.split(' '));
            navbar.classList.add(...transparentClasses.split(' '));

            navbarLinks.forEach(link => {
                link.classList.remove(...blackLinkClasses.split(' '));
                link.classList.add(...transparentLinkClasses.split(' '));
            });

            toggleMenu.classList.remove('text-tertiery1');
            toggleMenu.classList.add('text-white');

            if (loginBtn) {
                loginBtn.classList.remove('btn-secondary-custom');
                loginBtn.classList.add('btn-tertiery-custom');
            }
        }
    }

    function setActiveLink() {
        const hash = window.location.hash;
        const links = document.querySelectorAll('.nav-link');

        links.forEach(link => {
            // Hapus kelas aktif dari semua tautan
            link.classList.remove('active');

            // Tambahkan kelas aktif jika data-hash cocok dengan hash saat ini
            if (link.dataset.hash === hash || (hash === '' && link.dataset.hash === '#')) {
                link.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    window.addEventListener('hashchange', setActiveLink);
    handleScroll();
    setActiveLink();
}
