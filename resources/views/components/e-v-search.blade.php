<div class="container grid grid-cols-1 lg:grid-cols-2 py-24 mx-auto">
    <div class="flex flex-col justify-center px-12 py-36">
        <x-application-logo class="block w-auto h-10 text-gray-600 fill-current self-start mb-10"/>
        <x-label :label="ev_dynamic_translate($header, true)" class="mt-5 mb-2 text-indigo-600 font-semibold leading-[55px]"></x-label>
        <x-label :label="ev_dynamic_translate($title, true)" class="text-6xl font-bold tracking-tighter"></x-label>
        <x-label :label="ev_dynamic_translate($description, true)" class="mb-5 mt-8 text-gray-500 text-[20px]"></x-label>
        <x-search.e-v-search-form class="mt-5 mb-8"></x-search.e-v-search-form>
        <x-label :label="ev_dynamic_translate($footer, true)" class="font-semibold"></x-label>
    </div>
    <div class="flex flex-col">
        <img src="{{ $image }}" class="h-full" />
    </div>    
</div>