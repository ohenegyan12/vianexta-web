/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#D8501C",
                secondary: "#07382F",
                accent: "#FCEFE3",
                neutral: "#2a323c",
                "base-100": "#1d232a",
                info: "#3abff8",
                success: "#36d399",
                warning: "#fbbd23",
                error: "#f87272",
            },
            fontFamily: {
                sora: ["Sora", "sans-serif"],
            },
            maxWidth: {
                "8xl": "90rem",
                "9xl": "100rem",
            },
        },
    },
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")[
                    "[data-theme=light]"
                    ],
                    primary: "#D8501C",
                    secondary: "#07382F",
                    accent: "#FCEFE3",
                    neutral: "#2a323c",
                    "base-100": "#1d232a",
                    info: "#3abff8",
                    success: "#36d399",
                    warning: "#fbbd23",
                    error: "#f87272",

                    ".btn-primary": {
                        "background-color": "#D8501C",
                        "border-color": "#D8501C",

                        "text-transform": "none",
                        color: "#ffffff",
                    },
                    ".btn-primary:hover": {
                        "background-color": "#121212",
                        "border-color": "#121212",
                    },
                    ".btn-secondary": {
                        "background-color": "#07382F",
                        "border-color": "#07382F",
                        "text-transform": "none",
                        color: "#ffffff",
                    },
                    ".btn-secondary:hover": {
                        "background-color": "#121212",
                        "border-color": "#07382F",
                    },
                    ".input": {
                        "background-color": "#ffffff",
                        "border-color": "#07382F",
                    },
                    ".input:focus": {
                        "background-color": "#ffffff",
                        "border-color": "#07382F",
                    },
                    ".radio-primary:checked": {
                        "background-color": "#07382F",
                        "border-color": "#07382F",
                    },
                    ".radio-primary": {
                        "border-color": "#07382F",
                    },
                },
            },
        ],
    },

    plugins: [require("daisyui")],
};
