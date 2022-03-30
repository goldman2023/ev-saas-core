{{-- This is a separate file, you can overide global config in a child theme
Example in themes/ev-saas-fox/views/frontend/layouts/global-partials/global-tailwind-config.blade.php
TODO: you can overide it with data from a database a sa setting --}}

{{-- This is required when overiding this file --}}
<style type="text/tailwindcss">
    @layer utilities {
        [x-cloak] {
            @apply hidden;
        }
    }
</style>



<script>
    tailwind.config = {
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
                    sans: ['Arial', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', 'sans-serif'],
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
                    indigo: '#8BC53F',
                    primary: '#8BC53F',
                    primaryLight: '#EBF8DC',
                    primaryDark: '#657934',
                    secondary: '#FF8E3B',
                    secondaryLight: '#FFD53F',
                    secondaryDark: '',
                    info: '#219FFF',
                    infoLight: '#E9F6FF',
                    success: '#17BD8D',
                    successLight: '#E9FBF6',
                    warning: '#FFA114',
                    warningLight: '#FFF7EB',
                    danger: '#8BC53F',
                    dangerLight: '#FFEDEC',
                }
            }
          }
        }
</script>

<style>
    @layer utilities {
        [x-cloak] {
            @apply hidden;
        }

        .btn-standard {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover: bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700;
        }

        .btn-standard {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover: bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700;
        }

        .btn-primary {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover: bg-primaryDark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary;
        }

        .btn-success {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-success hover: bg-success focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success;
        }

        .btn-danger {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-danger rounded-md shadow-sm text-sm font-medium text-white bg-white hover: bg-danger focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger;
        }

        .btn-ghost {
            @apply cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-primary bg-transparent hover: text-primaryDark;
        }

        .badge-info {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-infoLight text-info;
        }

        .badge-success {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-successLight text-success;
        }

        .badge-warning {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warningLight text-warning;
        }

        .badge-danger {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dangerLight text-danger;
        }

        .badge-dark {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 text-white;
        }

        .form-standard {
            @apply flex-1 block w-full max-w-lg focus: ring-primary focus:border-primary min-w-0 rounded-md sm:text-sm border-gray-300 shadow-sm;
        }

        .form-checkbox-standard {
            @apply focus: ring-primary h-5 w-5 text-primary border-gray-300 rounded cursor-pointer;
        }

        .form-radio-standard {
            @apply focus: ring-primary h-5 w-5 text-primary border-gray-300 cursor-pointer;
        }

        .is-invalid {
            @apply border-danger;
        }

        .container {
            max-width: 100%;
            width: 1140px;
            margin: 0 auto;
        }

        .card {
            @apply bg-white border-2 border-gray-300 rounded-lg shadow-lg p-3;
        }

        .we-dashboard-sidebar-background {
            /* background-color: "{{ get_setting('we_dashboard_sidebar_background_color', '#f5f5f5') }}"; */
        }
    }
</style>
