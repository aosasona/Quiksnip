/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./src/**/*.php",
        "./src/**/*.html",
    ],
    theme: {
        container: {
            center: true,
            screens: {
                sm: "90vw",
            }
        },
        extend: {},
    },
    plugins: [],
}