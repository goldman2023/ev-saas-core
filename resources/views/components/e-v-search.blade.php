<div class="container grid grid-cols-1 lg:grid-cols-2 py-24 mx-auto">
    <div class="flex flex-col justify-center px-12 py-32">
        <x-application-logo class="block w-auto h-10 text-gray-600 fill-current self-start mb-10" />
        <x-ev.label :label="ev_dynamic_translate('EV Search Hero Title')"
            class="mt-5 mb-2 text-indigo-600 font-semibold leading-[55px]"></x-ev.label>
        <x-ev.label :label="ev_dynamic_translate('EV Search Hero Sub Title')" class="text-6xl font-bold tracking-tighter">
        </x-ev.label>
        <x-ev.label :label="ev_dynamic_translate('EV Search Hero Description')"
            class="mb-5 mt-8 text-gray-500 text-[20px]"></x-ev.label>
        <x-search.e-v-search-form class="mt-5 mb-8"></x-search.e-v-search-form>
        <x-ev.label :label="ev_dynamic_translate('EV Search Hero Footer Text')" class="font-semibold"></x-ev.label>
    </div>
    <div class="flex flex-col">
        <x-ev.dynamic-image alt="Any alt text" :src="ev_dynamic_translate('#home-search-image')">
        </x-ev.dynamic-image>
    </div>
</div>
