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
                <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('Product') }}</h3>
                <ul role="list" class="mt-4 space-y-4">
                  @if(!empty($footer_1_menu_items) && $footer_1_menu_items->isNotEmpty())
                      @foreach($footer_1_menu_items as $menu_item)
                          @if($menu_item['enabled'])
                          <li>
                              <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="text-base text-gray-300 hover:text-white">
                                {{ $menu_item['name'] ?? '' }}
                              </a>
                          </li>
                          @endif
                      @endforeach
                  @endif
                </ul>
            </div>

            <div class="mt-6 sm:mt-0">
                <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('Company') }}</h3>
                <ul role="list" class="mt-4 space-y-4">
                  @if(!empty($footer_2_menu_items) && $footer_2_menu_items->isNotEmpty())
                    @foreach($footer_2_menu_items as $menu_item)
                        @if($menu_item['enabled'])
                          <li>
                              <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="text-base text-gray-300 hover:text-white">
                                {{ $menu_item['name'] ?? '' }}
                              </a>
                          </li>
                        @endif
                    @endforeach
                @endif
                </ul>
            </div>

            <div class="mt-6 sm:mt-0">
                <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('Support') }}</h3>
                <ul role="list" class="mt-4 space-y-4">
                  @if(!empty($footer_3_menu_items) && $footer_3_menu_items->isNotEmpty())
                      @foreach($footer_3_menu_items as $menu_item)
                          @if($menu_item['enabled'])
                            <li>
                                <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="text-base text-gray-300 hover:text-white">
                                  {{ $menu_item['name'] ?? '' }}
                                </a>
                            </li>
                          @endif
                      @endforeach
                  @endif
                </ul>
            </div>
        </div>
        <div class="col-span-1 lg:col-span-2 mt-8 md:mt-0">
          <h3 class="text-sm font-semibold text-white tracking-wider uppercase">{{ translate('STAY UP TO DATE WITH') }} {{ get_site_name() }}</h3>
          <p class="mt-4 text-base text-gray-300">{{ translate('We promise, we will not use your contact information to send spam or share it with the third parties.') }}</p>
          <livewire:forms.newsletter-form />
        </div>
      </div>
      <div class="mt-8 border-t border-gray-600 pt-8 md:flex md:items-center md:justify-between">
        <div class="flex space-x-6 md:order-2">
          <a href="https://www.facebook.com/Pixprosoftware/" target="_blank" rel="nofollow" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">Facebook</span>
            @svg('icomoon-facebook2', ['class' => 'w-5 h-5'])
          </a>

          <a
          target="_blank" rel="nofollow"
          href="https://www.instagram.com/challenge/?next=/Pixpro_software/" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">Instagram</span>
            @svg('icomoon-instagram', ['class' => 'w-5 h-5'])

          </a>

          <a href="https://twitter.com/_Pixpro" target="_blank" rel="nofollow" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">Twitter</span>
            @svg('icomoon-twitter', ['class' => 'w-5 h-5'])

          </a>

          <a href="https://www.linkedin.com/company/pixpro-uab/" target="_blank" rel="nofollow" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">LinkedIn</span>
            @svg('icomoon-linkedin', ['class' => 'w-5 h-5'])

          </a>



          <a href="https://www.youtube.com/channel/UCZZh9WSA4rBDw542JwVOaCQ" target="_blank" rel="nofollow" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">Youtube</span>
            @svg('icomoon-youtube', ['class' => 'w-5 h-5'])
          </a>
        </div>
        <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">&copy; {{ date('Y') }} - {{ get_site_name() }}</p>
      </div>
    </div>
</footer>
