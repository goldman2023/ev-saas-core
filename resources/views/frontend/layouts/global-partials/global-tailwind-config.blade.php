{{-- This is a separate file, you can overide global config in a child theme
Example in themes/EvSaasFox/views/frontend/layouts/global-partials/global-tailwind-config.blade.php
TODO: you can overide it with data from a database a sa setting --}}
@php
$colors = TenantSettings::get('colors');

if($colors) {

}
@endphp

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
                    'primary': '{{ ($colors['primary'] ?? null) ?: '#f40000' }}',
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
                    'typ-1': '{{ ($colors['typography-1'] ?? null) ?: '#323B4B' }}',
                    'typ-2': '{{ ($colors['typography-2'] ?? null) ?: '#4E5D78' }}',
                    'typ-3': '{{ ($colors['typography-3'] ?? null) ?: '#8A94A6' }}',
                    'typ-4': '{{ ($colors['typography-4'] ?? null) ?: '#B0B7C3' }}',
                    'bg-1': '{{ ($colors['background-1'] ?? null) ?: '#C1C7D0' }}',
                    'bg-2': '{{ ($colors['background-2'] ?? null) ?: '#EBECF0' }}',
                    'bg-3': '{{ ($colors['background-3'] ?? null) ?: '#FAFBFC' }}',
                    'bg-4': '{{ ($colors['background-4'] ?? null) ?: '#FFFFFF' }}',
                    'indigo-100': '{{ ($colors['indigo-100'] ?? null) ?: '#f40000' }}',
                    'indigo-200': '{{( $colors['indigo-200'] ?? null) ?: '#f40000' }}',
                    'indigo-300': '{{ ($colors['indigo-300'] ?? null) ?: '#f40000' }}',
                    'indigo-400': '{{ ($colors['indigo-400'] ?? null) ?: '#f40000' }}',
                    'indigo-500': '{{ ($colors['indigo-500'] ?? null) ?: '#f40000' }}',
                    'indigo-600': '{{ ($colors['indigo-600'] ?? null) ?: '#f40000' }}',
                    'indigo-700': '{{ ($colors['indigo-700'] ?? null) ?: '#f40000' }}',
                    'indigo-800': '{{ ($colors['indigo-800'] ?? null) ?: '#f40000' }}',
                    'indigo-900': '{{ ($colors['indigo-900'] ?? null) ?: '#f40000' }}',
                }
            }
          }
        }
</script>

<style type="text/tailwindcss">
    @layer utilities {
        [x-cloak] {
            @apply hidden;
        }

        *::-webkit-scrollbar { width: 0 !important }

        body::-webkit-scrollbar { width: 5px !important }
        @if($colors)
        .btn-standard {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700;
        }
        .btn-standard-outline {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-gray-400 rounded-md shadow-sm text-sm font-medium text-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400;
        }

        .btn-primary {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary;
        }
        .btn-primary-outline {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-primary rounded-md shadow-sm text-sm font-medium text-primary bg-white hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary;
        }

        .btn-success {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-success hover:bg-success focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success;
        }
        .btn-warning {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-warning hover:bg-warning focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning;
        }
        .btn-info {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-info hover:bg-info focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-info;
        }
        .btn-danger {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-danger hover:bg-danger focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger;
        }
        .btn-danger-outline {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-danger rounded-md shadow-sm text-sm font-medium text-danger hover:text-white bg-white hover:bg-danger focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger;
        }

        .btn-ghost {
            @apply cursor-pointer inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-primary bg-transparent hover:text-primary-dark;
        }

        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }

        .badge-primary {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-light text-primary;
        }

        .badge-info {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-info-light text-info;
        }

        .badge-success {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-light text-success;
        }

        .badge-warning {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-light text-warning;
        }

        .badge-danger {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-light text-danger;
        }

        .badge-dark {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 text-white;
        }

        @endif

        .form-standard {
            @apply flex-1 block w-full focus:ring-primary focus:border-primary min-w-0 rounded-md sm:text-sm border-gray-300 shadow-sm;
        }

        .vat-input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .form-checkbox-standard {
            @apply focus:ring-primary h-5 w-5 text-primary border-gray-300 rounded cursor-pointer;
        }

        .form-radio-standard {
            @apply focus:ring-primary h-5 w-5 text-primary border-gray-300 cursor-pointer;
        }

        input[disabled] {
            @apply opacity-50;
        }

        .is-invalid {
            @apply border-danger;
        }

        .is-valid {
            @apply border-success;
        }

        .card {
            @apply relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden;
        }

        @media(max-width: 768px) {
            .we-horizontal-slider {
                display: grid;
                grid-template-columns: repeat(auto-fill,minmax(70%,1fr));
                grid-auto-flow: column;
                grid-auto-columns: minmax(70%,1fr);
                overflow-x: auto;
                grid-auto-flow: column;
                grid-auto-columns: minmax(70%,1fr);
                overflow-x: auto;
                padding-bottom: 20px;
            }
        }



        .container {
            @apply w-[1140px] max-w-[100%] px-5 lg:px-0 my-0 mx-auto;
        }

        [data-f-id] {
            @apply hidden;
        }

        .tooltip {
            @apply invisible absolute;
        }

        .has-tooltip:hover .tooltip {
            @apply visible z-50;
        }
        @if($colors)
        @if($colors['sidebar-bg'])
        .we-dashboard-sidebar-background {
            background-color: {{ $colors['sidebar-bg'] }} !important;
        }
        @endif
        @endif

        .we-sidebar-menu-item {
            @apply text-gray-600 !important;
        }

        .ev-icon__xs {
            max-width: 16px !important;
        }

    }
</style>
