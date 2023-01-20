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
        `${__dirname}/js/**/*.vue`, // absolute path
        `${__dirname}/js/**/*.js` // absolute path
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
            },
            colors: {
                /* Indigo is a primary brand color */
                'primary': '#8BC53F',
                'primary-hover': '#657934',
                'primary-light': '#EBF8DC',
                'primary-dark': '#657934',
                'secondary': '#FF8E3B',
                'secondary-hover': '#000',
                'secondary-light': '#FFD53F',
                'secondary-dark': '#657934',
                'info': '#219FFF',
                'info-light': '#E9F6FF',
                'success': '#17BD8D',
                'success-light': '#E9FBF6',
                'warning': '#FFA114',
                'warning-light': '#FFF7EB',
                'danger': '#FF4E3E',
                'danger-light': '#FFEDEC',
                'sidebar-bg': '#ffffff',
                'typ-1': '#303030',
                'typ-2': '#595959',
                'typ-3': '#747474',
                'typ-4': '#CBCBCB',
                'bg-1': '#C1C7D0',
                'bg-2': '#EBECF0',
                'bg-3': '#FAFBFC',
                'bg-4': '#FFFFFF',
                'indigo-100': '#E7F3D8',
                'indigo-200': '#D0E7B1',
                'indigo-300': '#B8DB8A',
                'indigo-400': '#A3D067',
                'indigo-500': '#8AC43F',
                'indigo-600': '#70A031',
                'indigo-700': '#527524',
                'indigo-800': '#374E18',
                'indigo-900': '#1B270C',
                'primary-100': '#E7F3D8',
                'primary-200': '#D0E7B1',
                'primary-300': '#B8DB8A',
                'primary-400': '#A3D067',
                'primary-500': '#8AC43F',
                'primary-600': '#70A031',
                'primary-700': '#527524',
                'primary-800': '#374E18',
                'primary-900': '#1B270C',
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
