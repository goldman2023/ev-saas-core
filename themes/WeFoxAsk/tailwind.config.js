const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require('tailwindcss/plugin');
let weMix = require('../../we-webpack-mix');

module.exports = {
    darkMode: 'class',
    content: weMix.getPurgePaths(__dirname, null),
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
                sans: ['Inter', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', 'sans-serif'],
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
            colors: {
                /* Indigo is a primary brand color */
                // 'primary': '#f41100',
                "primary": "var(--primary-color)",
                "secondary-color": "var(--secondary-color)",
                'primary-hover': '#000',
                'primary-light': '#EBF8DC',
                'primary-dark': '#657934',
                'secondary': '#FF8E3B',
                'secondary-hover': '#000',
                'secondary-light': '#FFD53F',
                'secondary-dark': '#657934',
                'info': '#219FFF',
                'info-light': '#E9F6FF',
                'success': '#657917',
                'success-light': '#E9FBF6',
                'warning': '#FFA114',
                'warning-light': '#FFF7EB',
                'danger': '#FF4E3E',
                'danger-light': '#FFEDEC',
                'sidebar-bg': '#000000',
                'typ-1': '#323B4B',
                'typ-2': '#4E5D78',
                'typ-3': '#8A94A6',
                'typ-4': '#B0B7C3',
                'bg-1': '#C1C7D0',
                'bg-2': '#EBECF0',
                'bg-3': '#FAFBFC',
                'bg-4': '#FFFFFF',
                'indigo-100': "var(--secondary-color)",
                'indigo-200': "var(--secondary-color)",
                'indigo-300': "var(--secondary-color)",
                'indigo-400': "var(--secondary-color)",
                'indigo-500': "var(--secondary-color)",
                'indigo-600': "var(--secondary-color)",
                'indigo-700': "var(--secondary-color)",
                'indigo-800': "var(--secondary-color)",
                'indigo-900': "var(--secondary-color)",
                'primary-100': "var(--primary-color)",
                'primary-200': "var(--primary-color)",
                'primary-300': "var(--primary-color)",
                'primary-400': "var(--primary-color)",
                'primary-500': "var(--primary-color)",
                'primary-600': "var(--primary-color)",
                'primary-700': "var(--primary-color)",
                'primary-800': "var(--primary-color)",
                'primary-900': "var(--primary-color)",
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
