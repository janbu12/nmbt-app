import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                bg1: '#DDF2FD',
                primary1: "#    427D9D",
                secondary1: "#9BBEC8",
                tertiery1: '#164863',
                bg2: "#DCF2F1",
                primary2: "#7FC7D9",
                secondary2: "#365486",
                tertiery2: "#0F1035",
                bg3: "#F3F3E0",
                primary3: "#133E87",
                secondary3: "#608BC1",
                tertiery3: "#CBDCEB",
            },
        },
    },
    plugins: [
        require('daisyui'),
      ],
    daisyui: {
        themes: false,
        darkTheme: false, // Disable dark mode
    },
};
