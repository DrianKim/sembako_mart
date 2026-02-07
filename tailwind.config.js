/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Source Sans Pro", "sans-serif"],
            },
            colors: {
                orange: {
                    400: "#FB923C",
                    500: "#F97316",
                    600: "#EA580C",
                },
            },
        },
    },
    plugins: [],
};
