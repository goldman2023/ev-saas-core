@php
$footer_menu = nova_get_menu_by_slug('footer')['menuItems'] ?? null;
$footer_menu_2 = nova_get_menu_by_slug('footer-2')['menuItems'] ?? null;
$footer_menu_3 = nova_get_menu_by_slug('footer-3')['menuItems'] ?? null;
@endphp
<footer class="bg-white dark:bg-gray-800">
    <div class="py-6 mx-auto container md:p-6 lg:p-6">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-3 lg:grid-cols-5">
            <div>
                <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                    {{ translate('For Customers') }}
                </h2>
                <nav class="">
                    @if(!empty($footer_menu) && $footer_menu->isNotEmpty())
                    @foreach($footer_menu as $menu_item)
                    @if($menu_item['enabled'])
                    <div class="py-2">
                        <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
                            class="text-base text-gray-500 hover:text-gray-900">
                            {{ $menu_item['name'] ?? '' }}
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @else
                    @auth
                    @if(auth()->user()->isAdmin())
                    <a href="/we/admin/menus" target="_blank" type="button"
                        class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                        </svg>
                        <span class="mt-2 block text-sm font-medium text-gray-900">
                            {{ translate('Create Footer Menu') }}
                        </span>
                    </a>

                    @endif
                    @endauth
                    @endif
                </nav>
            </div>

            <div>
                <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                    {{ translate('Our products') }}
                </h2>
                <nav class="">
                    @if(($footer_menu_2) && $footer_menu_2->isNotEmpty())
                    @foreach($footer_menu_2 as $menu_item)
                    @if($menu_item['enabled'])
                    <div class="py-2">
                        <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
                            class="text-base text-gray-500 hover:text-gray-900">
                            {{ $menu_item['name'] ?? '' }}
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @else
                    @auth
                    @if(auth()->user()->isAdmin())
                    <a href="/we/admin/menus" target="_blank" type="button"
                        class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                        </svg>
                        <span class="mt-2 block text-sm font-medium text-gray-900">
                            {{ translate('Create Footer Menu') }}
                        </span>
                    </a>

                    @endif
                    @endauth
                    @endif
                </nav>
            </div>

            <div>
                <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                    {{ translate('Company') }}
                </h2>
                <nav class="">
                    @if(!empty($footer_menu_3) && $footer_menu_2->isNotEmpty())
                    @foreach($footer_menu_3 as $menu_item)
                    @if($menu_item['enabled'])
                    <div class="py-2">
                        <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
                            class="text-base text-gray-500 hover:text-gray-900">
                            {{ $menu_item['name'] ?? '' }}
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div class="w-full">
                        <x-system.empty-state></x-system.empty-state>

                    </div>
                    @endif
                </nav>
            </div>



            <div class="col-span-2 text-right">
                <h2 class="text-right mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                    {{ get_site_name() }}
                </h2>
                <a href="/"
                class="inline flex text-right justify-end items-center mb-5 text-2xl font-semibold text-gray-900 dark:text-white">
                <img src="{{ get_site_logo() }}" class="inline max-w-[200px]" loading="lazy" alt="{{ get_site_name() }}" />
            </a>

                {{-- <livewire:forms.newsletter-form /> --}}
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8">
        <div class="text-center">

            <span class="block text-sm text-center text-gray-500 dark:text-gray-400">© {{ date('Y') }} <a href="#"
                    class="hover:underline">{{ get_site_name() }}</a>. {{ translate('All Rights Reserved.') }}
            </span>

        </div>
    </div>
</footer>

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js-eu1.hs-scripts.com/26534495.js"></script>
<!-- End of HubSpot Embed Code -->
