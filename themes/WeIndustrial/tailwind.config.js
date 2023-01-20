const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');
const defaultWeTheme = 'WeTailwind';
let weMix = require('../../we-webpack-mix');

module.exports = {
    content: weMix.getPurgePaths(__dirname, defaultWeTheme),

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
