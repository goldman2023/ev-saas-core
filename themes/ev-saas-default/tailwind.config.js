module.exports = {
  content: [
    "./resources/views/frontend/checkout-single.blade.php", // relative path from the root of the project!
    `${__dirname}/views/**/*.blade.php` // absolute path to theme
  ],
  theme: {
    screens: {
      'sm': '600px',
      'md': '950px',
      'lg': '1200px',
      'xl': '1500px',
    },
    extend: {
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
        '36': '36px',
        '48': '48px',
        '52': '52px',
        '94': '94px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/typography'),
    require('tailwindcss-children'),
    require('@tailwindcss/line-clamp'),
  ],
}
