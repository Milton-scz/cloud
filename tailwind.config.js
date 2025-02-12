import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Habilitar el modo oscuro basado en clases
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                dancing: ['"Dancing Script"', 'cursive'], // Añadir Dancing Script aquí
                niño: ['"Comic Sans MS"', 'cursive'],
                adolescente: ['"Dancing Script"', 'cursive'],
                adulto: ['"Roboto"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                niño: {
                    light: '#ffeb3b',  // Amarillo claro
                    dark: '#b28704',   // Amarillo oscuro
                },
                adolescente: {
                    light: '#2196f3',  // Azul claro
                    dark: '#1a64a5',   // Azul oscuro
                },
                adulto: {
                    light: '#f4f4f4',  // Gris claro
                    dark: '#1a1a1a',   // Gris oscuro
                }
            },
        },
    },

    plugins: [forms],
};
