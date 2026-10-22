import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/**/*.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Inter", ...defaultTheme.fontFamily.sans],
        serif: ["Playfair Display", "Georgia", "serif"],
      },
      colors: {
        ink: "#25241f",
        muted: "#77766f",
        paper: "#faf9f6",
        cream: "#f3f0e9",
        olive: "#8f8961",
        gold: "#a99361",
      },
      boxShadow: { soft: "0 12px 45px rgba(45,39,25,.08)" },
    },
  },
  plugins: [forms],
};
