import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'dark-green': '#618264',
                'darker-green':'#304031',
                'mid-green': '#B0D9B1',
                'selected-green':'#79AC78',
                'pale-green':'#DDF0E6',
              },
        },
    },

    plugins: [forms],
};
