const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'first'  : '#8CAFCE',
                // 'first'  : 'rgb(36 98 162)',
                'sec'    : '#2f2e41',
                'success': '#36D399',
                'error'  : '#ff7674',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'),require("daisyui")],
};
