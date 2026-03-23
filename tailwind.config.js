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
            colors: {
                "primary": "#308ce8",
                "secondary": "#fbbf24",
                "accent": "#f472b6",
                "accent-blue":      "#e0f2fe",
                "accent-yellow":    "#fef3c7",
                "accent-pink":      "#fce7f3",
                "accent-purple":    "#ede9fe",
                "accent-green":     "#dcfce7",
                "cta-pink":         "#e85d97",
                "background-light": "#f6f7f8",
                "background-dark":  "#111921",
            },
            fontFamily: {
                sans: ['Lexend', ...defaultTheme.fontFamily.sans],
                display: ['Lexend', 'sans-serif'],
            },
            borderRadius: {
                "DEFAULT": "1rem",
                "lg":      "1.5rem",
                "xl":      "2.5rem",
                "2xl":     "3rem",
                "full":    "9999px",
            },
        },
    },

    plugins: [forms],
};
