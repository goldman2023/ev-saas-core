<!-- This example requires Tailwind CSS v2.0+ -->
<section class="mt-16 mx-auto max-w-7xl px-4 sm:mt-24">

    <div class="text-center">
        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
            <span class="block xl:inline">


                <x-label :label="ev_dynamic_translate('Welcome to your new Digital Home')">
                </x-label>
            </span>
            <br>
            <span class="block text-3xl text-indigo-600 xl:inline">
                <x-label :label="ev_dynamic_translate('Get Started By Adding your Information')">
                </x-label>

            </span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
            <x-label :label="ev_dynamic_translate('Your Business Description')">
            </x-label>
        </p>
        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
            <div class="rounded-md shadow">
                <a href="{{ ev_dynamic_translate('#button-1')->value }}"
                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                    <x-label :label="ev_dynamic_translate('Button 1')">
                    </x-label>
                </a>
            </div>
            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                <a href="{{ ev_dynamic_translate('#button-2')->value }}" target="_blank"
                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                    <x-label :label="ev_dynamic_translate('Button 2')">
                    </x-label>
                </a>
            </div>
        </div>
    </div>
</section>
