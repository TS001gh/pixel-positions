/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            colors: {
                primary: "#060606",
                secondary: "#1544ef",
            },
            fontFamily: {
                "hanken-grotesk": ["Hanken Grotesk", "sans-serif"],
            },

            fontSize: {
                "2xs": "0.625rem",
            },
        },
    },
    plugins: [],
};
