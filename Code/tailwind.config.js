/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                background: "#08090d",
                surface: "#10131a",
                "surface-container-lowest": "#05060a",
                "surface-container-low": "#0d1016",
                "surface-container": "#131822",
                "surface-container-high": "#191f2c",
                "surface-container-highest": "#222a39",
                "surface-bright": "#2b3446",
                primary: "#ff8a3d",
                "primary-container": "#ff5b1f",
                "on-primary": "#fff6f1",
                secondary: "#ffbe64",
                "secondary-container": "#8a4d0f",
                tertiary: "#a7b7d6",
                "on-surface": "#f5f7fb",
                "on-surface-variant": "#b8c2d6",
                outline: "#46506a",
                "outline-variant": "#2a3243",
                error: "#ff8b8b",
                success: "#7cf0b7",
                warning: "#ffd36f",
            },
            fontFamily: {
                headline: ["Space Grotesk", "sans-serif"],
                body: ["Oxanium", "sans-serif"],
            },
            borderRadius: {
                xl: "0.25rem",
                "2xl": "0.35rem",
                "3xl": "0.5rem",
                "4xl": "0.75rem",
            },
            boxShadow: {
                glow: "0 0 0 1px rgba(255, 138, 61, 0.28), 0 18px 50px rgba(255, 91, 31, 0.26)",
                card: "0 28px 90px rgba(0, 0, 0, 0.42)",
                panel: "0 18px 44px rgba(0, 0, 0, 0.34)",
            },
            backgroundImage: {
                "veil-radial":
                    "radial-gradient(circle at 18% 20%, rgba(255, 91, 31, 0.24), transparent 24%), radial-gradient(circle at 82% 16%, rgba(255, 190, 100, 0.18), transparent 22%), radial-gradient(circle at 50% 100%, rgba(90, 122, 255, 0.12), transparent 34%), linear-gradient(180deg, #090b10 0%, #10141c 44%, #07080d 100%)",
                "hero-mist":
                    "linear-gradient(135deg, rgba(16, 19, 26, 0.96) 0%, rgba(22, 27, 39, 0.88) 52%, rgba(8, 9, 13, 0.98) 100%)",
                "button-primary":
                    "linear-gradient(135deg, #ff8a3d 0%, #ff5b1f 100%)",
                "button-ghost":
                    "linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03))",
            },
        },
    },
    plugins: [],
};
