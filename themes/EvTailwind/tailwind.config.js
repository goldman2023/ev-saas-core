const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');

module.exports = {
    darkMode: 'class',
    content: [
        `${__dirname}/views/**/*.blade.php`, // absolute path
        `./resources/views/components/**/*.blade.php`, // relative to root
        `./resources/views/livewire/**/*.blade.php`, // relative to root
        `./resources/views/layouts/**/*.blade.php`, // relative to root
        `./resources/views/we-edit/**/*.blade.php`, // relative to root
    ],
    theme: {
        screens: {
            'mobile': {'min': '300px', 'max': '599px'},
            'tablet-portrait-up': '600px',
            'tablet-landscape-up': '900px',
            'laptop-up': '1200px',
            'desktop-up': '1500px',
            'xs': {'min': '300px', 'max': '599px'},
            'sm': '600px',
            'md': '900px',
            'lg': '1200px',
            'xl': '1500px',
          },
        extend: {
            fontFamily: {
                sans: ['Inter var', 'Poppins', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto'],
            },
            fontSize: {
                '10': '10px',
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
                '28': '28px',
                '30': '30px',
                '32': '32px',
                '34': '34px',
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
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography'),
        require('tailwindcss-children'),
        require('@tailwindcss/line-clamp'),

        plugin(function({ addUtilities }) {
            // Add new classes if needed
        }),
    ],
};
