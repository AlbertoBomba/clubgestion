import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Paleta Principal
                'primary': '#005DFF',        // Azul Eléctrico - tecnología, confianza, energía
                'black-deep': '#0D0D0D',     // Negro Profundo - fuerza, premium, elegancia
                'white-pure': '#FFFFFF',      // Blanco Puro - limpieza, claridad, profesional
                'neon-green': '#00E685',     // Verde Neón Energético - velocidad, juventud, acción
                
                // Paleta Secundaria
                'titanium': '#2A2A2A',       // Gris Titanio
                'silver': '#CCCCCC',         // Gris Plata
                'night-blue': '#001C40',     // Azul Noche
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'slide-in-left': 'slideInLeft 0.8s ease-out',
                'slide-in-right': 'slideInRight 0.8s ease-out',
                'scroll-logos': 'scroll-logos 30s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                slideInLeft: {
                    from: {
                        transform: 'translateX(-50px)',
                        opacity: '0',
                    },
                    to: {
                        transform: 'translateX(0)',
                        opacity: '1',
                    },
                },
                slideInRight: {
                    from: {
                        transform: 'translateX(50px)',
                        opacity: '0',
                    },
                    to: {
                        transform: 'translateX(0)',
                        opacity: '1',
                    },
                },
                'scroll-logos': {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
        },
    },

    plugins: [forms, typography],
};
