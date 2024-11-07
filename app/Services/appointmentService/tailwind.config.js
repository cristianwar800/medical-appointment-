import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'media', // Media or 'class' if you want to toggle manually in your application

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: { // Ejemplo de extensión de colores para modo oscuro
                gray: {
                    100: '#f7fafc',
                    900: '#1a202c',
                },
            },
            backgroundColor: { // Ejemplo de cómo extender los colores de fondo
                page: '#f7fafc',
            },
        },
    },

    plugins: [forms],

    // Añadiendo el extend para los estilos específicos del modo oscuro
    extend: {
        backgroundColor: {
            dark: { // Definiendo colores específicos para el modo oscuro
                page: '#1a202c',
            },
            light: { // Colores para el modo claro si necesitas cambiar dinámicamente
                page: '#f7fafc',
            },
        },
    },
};
