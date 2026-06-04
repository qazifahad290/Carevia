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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50:  '#F1ECFF',
                    100: '#E2D6FF',
                    200: '#C5ADFF',
                    300: '#A684FF',
                    400: '#8A5CFF',
                    500: '#5B2EE6',
                    600: '#4A22C2',
                    700: '#3A1899',
                    800: '#2A1070',
                    900: '#1A0A47',
                },
                surface: {
                    50:  '#FBFAFF',
                    100: '#F5F4FF',
                    200: '#ECE9FF',
                },
                ink: {
                    900: '#0F0B1F',
                    700: '#2B2440',
                    500: '#5C5478',
                    400: '#7E7796',
                },
            },
            boxShadow: {
                card: '0 4px 16px -4px rgba(92, 46, 255, 0.08), 0 2px 4px -2px rgba(15, 11, 31, 0.04)',
                cardHover: '0 12px 28px -8px rgba(92, 46, 255, 0.18), 0 4px 8px -4px rgba(15, 11, 31, 0.06)',
            },
            borderRadius: {
                '2.5xl': '1.25rem',
            },
        },
    },

    plugins: [forms],
};
