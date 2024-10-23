import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import flowbite from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./node_modules/flowbite/**/*.{js,jsx,ts,tsx}",
        "./node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#eff6ff",
                    100: "#dbeafe",
                    200: "#bfdbfe",
                    300: "#93c5fd",
                    400: "#60a5fa",
                    500: "#3b82f6",
                    600: "#2563eb",
                    700: "#1d4ed8",
                    800: "#1e40af",
                    900: "#1e3a8a",
                    950: "#172554",
                },
                secondary: {
                    50: "#e3f0d8",
                    100: "#c4e1a6",
                    200: "#a2d073",
                    300: "#7ac44f",
                    400: "#5ab43b",
                    500: "#79AF62",
                    600: "#699a4e",
                    700: "#4a7a39",
                    800: "#2f5c26",
                    900: "#143b15",
                    950: "#0b220a",
                },
            },
        },
    },

    plugins: [forms, typography, flowbite],

    darkMode: "media",
};
