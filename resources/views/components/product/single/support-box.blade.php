<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white rounded shadow mt-8">
    <h2 class="p-3 sm:p-6 font-medium text-xl">

        {{ translate('Have questions about this product?') }}
    </h2>
    <div class="grid grid-cols-2 mx-auto max-w-7xl  lg:justify-center lg:py-8">
        <div class="py-8  mb-3 lg:flex-none lg:py-0">
            <div class="mx-auto flex text-center max-w-xs items-center px-4 lg:max-w-none lg:px-8">
                <!-- Heroicon name: outline/calendar -->
                <img src="{{ get_site_logo() }}"
                    class="mx-auto rounded-full border border-1 p-2 h-16 w-16 mb-3 flex-shrink-0 text-indigo-600" />
                <div>
                    <div class="ml-4 flex flex-auto flex-col">
                        <h3 class="font-medium text-gray-900">
                            {{ get_site_name() }} {{ translate('Customer Support') }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ translate('Klientų aptarnavimo specialistai padės jums visais kylančiais klausimais') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="py-8 mb-3 text-center">
            <div class="mx-auto max-w-xs items-center px-4 lg:max-w-none lg:px-8">
                <!-- Heroicon name: outline/arrow-path -->
                <svg class="h-8 w-8 mb-3 mx-auto flex-shrink-0 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12c0-1.232.046-2.453.138-3.662a4.006 4.006 0 013.7-3.7 48.678 48.678 0 017.324 0 4.006 4.006 0 013.7 3.7c.017.22.032.441.046.662M4.5 12l-3-3m3 3l3-3m12 3c0 1.232-.046 2.453-.138 3.662a4.006 4.006 0 01-3.7 3.7 48.657 48.657 0 01-7.324 0 4.006 4.006 0 01-3.7-3.7c-.017-.22-.032-.441-.046-.662M19.5 12l-3 3m3-3l3 3" />
                </svg>
                <div class="ml-4 flex flex-auto flex-col-reverse">
                    <h3 class="font-medium text-gray-900">Free shipping on returns</h3>
                    <p class="text-sm text-gray-500">Send it back for free</p>
                </div>
            </div>
        </div>
        <div>
        </div>
        <div class="py-8 text-center lg:flex-none">
            <div class="mx-auto max-w-xs items-center px-4 lg:max-w-none lg:px-8">
                <!-- Heroicon name: outline/truck -->
                <svg class="h-8 w-8 mx-auto mb-3 flex-shrink-0 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <div class="ml-4 flex flex-auto flex-col-reverse">
                    <h3 class="font-medium text-gray-900">Free, contactless delivery</h3>
                    <p class="text-sm text-gray-500">The shipping is on us</p>
                </div>
            </div>
        </div>
    </div>
</div>
