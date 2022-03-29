{{-- TODO: Update this once shop settings are implemented for managing the logo --}}
<x-tenant.system.image alt="{{ get_site_name() }} logo"
width="{{ $width ?? '126' }}" height="{{ $height ?? '24' }}"
class="h-8 w-auto sm:h-10 fill-current"
    :image="get_tenant_setting('header_logo')">
</x-tenant.system.image>
