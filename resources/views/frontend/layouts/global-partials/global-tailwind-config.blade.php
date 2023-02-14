{{-- This is a separate file, you can overide global config in a child theme
Example in themes/WeFoxAsk/views/frontend/layouts/global-partials/global-tailwind-config.blade.php
TODO: you can overide it with data from a database a sa setting --}}
@php
$colors = TenantSettings::get('colors');
@endphp

<style>
    /* Custom variables to overide colors and other css parameters */
    :root {
        --primary-color: {{ $colors['primary'] }};
        --secondary-color: {{ $colors['secondary'] }};
    }
</style>
