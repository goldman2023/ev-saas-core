{{-- This is a separate file, you can overide global config in a child theme
Example in themes/WeFoxAsk/views/frontend/layouts/global-partials/global-tailwind-config.blade.php
TODO: you can overide it with data from a database a sa setting --}}
@php
$colors = TenantSettings::get('colors');
@endphp
@if(tenant())
<style>
    /* Custom variables to overide colors and other css parameters */
    :root {
        --primary-color: {{ $colors['primary'] }};
        --secondary-color: #333333;
    }
</style>
@endif
<script>
    tailwind.config = {
          darkMode: 'class',
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
                    roboto: ['Times New Roman'],
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
                    "primary": "var(--primary-color)",
                    "secondary-color": "var(--secondary-color)",
                    'primary-hover': '{{ ($colors['primary-hover'] ?? null) ?: '#000' }}',
                    'primary-light': '{{ ($colors['primary-light'] ?? null) ?: '#EBF8DC' }}',
                    'primary-dark': '{{ ($colors['primary-dark'] ?? null) ?: '#657934' }}',
                    'secondary': '{{ ($colors['secondary'] ?? null) ?: '#FF8E3B' }}',
                    'secondary-hover': '{{ ($colors['secondary-hover'] ?? null) ?: '#000' }}',
                    'secondary-light': '{{ ($colors['secondary-light'] ?? null) ?: '#FFD53F' }}',
                    'secondary-dark': '{{ ($colors['secondary-dark'] ?? null) ?: '#657934' }}',
                    'info': '{{ ($colors['info'] ?? null) ?: '#219FFF' }}',
                    'info-light': '{{ ($colors['info-light'] ?? null) ?: '#E9F6FF' }}',
                    'success': '{{ ($colors['success'] ?? null) ?: '#657917' }}',
                    'success-light': '{{ ($colors['success-light'] ?? null) ?: '#E9FBF6' }}',
                    'warning': '{{ ($colors['warning'] ?? null) ?: '#FFA114' }}',
                    'warning-light': '{{ ($colors['warning-light'] ?? null) ?: '#FFF7EB' }}',
                    'danger': '{{ ($colors['danger'] ?? null) ?: '#FF4E3E' }}',
                    'danger-light': '{{ ($colors['danger-light'] ?? null) ?: '#FFEDEC' }}',
                    'sidebar-bg': '{{ ($colors['sidebar-bg'] ?? null) ?: '#000000' }}',
                    'indigo-100': '{{ ($colors['indigo-100'] ?? null) ?: '#000000' }}',
                    'indigo-200': '{{( $colors['indigo-200'] ?? null) ?: '#000000' }}',
                    'indigo-300': '{{ ($colors['indigo-300'] ?? null) ?: '#000000' }}',
                    'indigo-400': '{{ ($colors['indigo-400'] ?? null) ?: '#000000' }}',
                    'indigo-500': '{{ ($colors['indigo-500'] ?? null) ?: '#000000' }}',
                    'indigo-600': '{{ ($colors['indigo-600'] ?? null) ?: '#000000' }}',
                    'indigo-700': '{{ ($colors['indigo-700'] ?? null) ?: '#000000' }}',
                    'indigo-800': '{{ ($colors['indigo-800'] ?? null) ?: '#000000' }}',
                    'indigo-900': '{{ ($colors['indigo-900'] ?? null) ?: '#000000' }}',
                    'primary-100': '{{ ($colors['indigo-100'] ?? null) ?: '#000000' }}',
                    'primary-200': '{{( $colors['indigo-200'] ?? null) ?: '#000000' }}',
                    'primary-300': '{{ ($colors['indigo-300'] ?? null) ?: '#000000' }}',
                    'primary-400': '{{ ($colors['indigo-400'] ?? null) ?: '#000000' }}',
                    'primary-500': '{{ ($colors['indigo-500'] ?? null) ?: '#000000' }}',
                    'primary-600': '{{ ($colors['indigo-600'] ?? null) ?: '#000000' }}',
                    'primary-700': '{{ ($colors['indigo-700'] ?? null) ?: '#000000' }}',
                    'primary-800': '{{ ($colors['indigo-800'] ?? null) ?: '#000000' }}',
                    'primary-900': '{{ ($colors['indigo-900'] ?? null) ?: '#000000' }}',
                }
            }
          }
        }
</script>

