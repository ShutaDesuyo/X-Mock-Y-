/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                x: {
                    bg: '#000000',
                    surface: '#16181c',
                    border: '#2f3336',
                    text: '#e7e9ea',
                    muted: '#71767b',
                    blue: '#1d9bf0',
                    'blue-hover': '#1a8cd8',
                    red: '#f4212e',
                    green: '#00ba7c',
                },
            },
        },
    },
    plugins: [],
};
