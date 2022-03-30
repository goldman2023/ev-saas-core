<!-- This example requires Tailwind CSS v2.0+ -->
<div {{ $attributes->merge(['class' => 'relative']) }}>
    @if(!get_tenant_setting('support_phone'))
    {{-- Empty state, ask user to fill out the details --}}
    <div class="absolute bottom-0 right-0 block h-full w-full bg-white/90 z-10">

        <!-- This example requires Tailwind CSS v2.0+ -->
        <a type="button" href="{{ route('settings.shop_settings') }}"
            class="relative block w-full h-full border-2 border-gray-300 border-dashed rounded-lg p-4 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="emoji">
                📱
            </span>
            <span class="mt-2 mb-2 block text-sm font-medium text-gray-700">
                {{ translate("Enter your support contacts and working hours")}} </span>

                <button type="button"
                class="btn-primary inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ translate('Support settings') }}
            </button>
        </a>
    </div>
    @endif
    <div class="flex items-start flex-wrap">
        <div class="flex-shrink-0 pt-0.5 relative w-full">
            <div class="relative w-auto inline-block mb-3">

                <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-10 rounded-full object-cover"
                    :image="get_site_logo()">
                </x-tenant.system.image>
                <span
                    class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white bg-green-400"></span>
            </div>

        </div>
        <div class="ml-3 flex-0 w-full">
            <p class="text-sm font-medium text-gray-900">{{ get_site_name() }} {{ translate('Customer Care') }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ translate('Have questions? We are available') }}</p>
            <div class="mt-4 flex">
                <button type="button"
                    class="btn-primary inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ translate('Talk with us') }} <span class="emoji ml-2">📱</span>
                </button>
            </div>
        </div>
    </div>
</div>
