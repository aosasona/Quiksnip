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
                sm: "88vw",
            }
        },
        extend: {},
    },
    plugins: [],
}