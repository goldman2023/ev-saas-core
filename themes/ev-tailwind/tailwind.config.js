const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');

module.exports = {
    mode: 'jit',
    purge: [
        `${__dirname}/views/**/*.blade.php`, // absolute path
        `./resources/views/components/**/*.blade.php`, // relative to root
        `./resources/views/livewire/**/*.blade.php`, // relative to root
        `./resources/views/layouts/**/*.blade.php`, // relative to root
        `${__dirname}/js/**/*.vue`, // absolute path
        `${__dirname}/js/**/*.js` // absolute path
    ],
    theme: {
        screens: {
            'xs': '500px',
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1320px',
            '2xl': '1536px',
            '3xl': '1600px',
        },
        extend: {
            fontFamily: {
                sans: ['Inter var', 'Poppins', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto'],
            },
            fontSize: {
                '11': '11px',
                '12': '12px',
                '13': '13px',
                '14': '14px',
                '16': '16px',
                '18': '18px',
                '20': '20px',
                '22': '22px',
                '24': '24px',
                '26': '26px',
                '36': '36px',
                '48': '48px',
                '52': '52px',
                '94': '94px',
            },
            lineClamp: {
                7: '7',
                8: '8',
                9: '9',
                10: '10',
                11: '11',
                12: '12',
            },
            keyframes: {
                loader: {
                    '0%, 80%, 100%': { transform: 'scale(0)', opacity: '0.2' },
                    '40%': { transform: 'scale(1)', opacity: '0.8' }
                }
            },
            animation: {
                loader: 'loader 1.48s ease-in-out infinite both',
            }
        },
    },

    variants: {
        extend: {

        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/aspect-ratio'),
        require('tailwindcss-pseudo-elements'),

        plugin(function({ addUtilities }) {
            // Add new classes if needed
        }),
    ],
};
