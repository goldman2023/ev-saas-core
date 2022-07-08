@php
$footer_1_menu = nova_get_menu_by_slug('footer_1');
$footer_1_menu_items = $footer_1_menu['menuItems'] ?? null;

$footer_2_menu = nova_get_menu_by_slug('footer_2');
$footer_2_menu_items = $footer_2_menu['menuItems'] ?? null;

$footer_3_menu = nova_get_menu_by_slug('footer_3');
$footer_3_menu_items = $footer_3_menu['menuItems'] ?? null;
@endphp
<footer class="bg-[#303030]" aria-labelledby="footer-heading">
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-5 lg:py-16 lg:px-8">
        <div class="lg:grid lg:grid-cols-5 lg:gap-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 col-span-1 lg:col-span-3">
                <div>
                    @if(!empty($footer_1_menu_items) && $footer_1_menu_items->isNotEmpty())
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('Product') }}
                    </h3>
                    <ul role="list" class="mt-4 space-y-4">

                        @foreach($footer_1_menu_items as $menu_item)
                        @if($menu_item['enabled'])
                        <li>
                            <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
                                class="text-base text-gray-300 hover:text-white">
                                {{ $menu_item['name'] ?? '' }}
                            </a>
                        </li>
                        @endif
                        @endforeach

                    </ul>
                    @endif
                </div>

                <div class="mt-6 sm:mt-0">
                @if(!empty($footer_2_menu_items) && $footer_2_menu_items->isNotEmpty())

                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('Company') }}
                    </h3>
                    <ul role="list" class="mt-4 space-y-4">

                        @foreach($footer_2_menu_items as $menu_item)
                        @if($menu_item['enabled'])
                        <li>
                            <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
                                class="text-base text-gray-300 hover:text-white">
                                {{ $menu_item['name'] ?? '' }}
                            </a>
                        </li>
                        @endif
                        @endforeach

                    </ul>
                    @endif
                </div>


                <div class="mt-6 sm:mt-0">
                @if(!empty($footer_3_menu_items) && $footer_3_menu_items->isNotEmpty())

                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('Support') }}
                    </h3>
                    <ul role="list" class="mt-4 space-y-4">
                        @foreach($footer_3_menu_items as $menu_item)
                        @if($menu_item['enabled'])
                        <li>
                            <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
                                class="text-base text-gray-300 hover:text-white">
                                {{ $menu_item['name'] ?? '' }}
                            </a>
                        </li>
                        @endif
                        @endforeach

                    </ul>
                    @endif
                </div>

            </div>
            <div class="col-span-1 lg:col-span-2 mt-8 xl:mt-0">
                <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('STAY UP TO DATE
                    WITH') }} {{ get_site_name() }}</h3>
                <p class="mt-4 text-base text-gray-300">{{ translate('We promise, we will not use your contact
                    information to send spam or share it with the third parties.') }}</p>
                <livewire:forms.newsletter-form />
            </div>
        </div>

    </div>
</footer>
