@php
    $header_menu = nova_get_menu_by_slug('header');
    $header_menu_items = $header_menu['menuItems'] ?? null;
@endphp
<div id="topbar" class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
    <button type="button" @click="$dispatch('display-flyout-panel', {'id': 'dashboard-sidebar-panel'})" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary lg:hidden">
      @svg('heroicon-o-menu-alt-2', ['class' => 'h-6 w-6'])
    </button>
    <div class="flex-1 px-4 flex justify-between">
      <div class="flex-1 flex text-center justify-center">
        <nav class="hidden md:flex space-x-[32px] items-center">
            @if(!empty($header_menu_items) && $header_menu_items->isNotEmpty())
                @foreach($header_menu_items as $menu_item)
                    @if($menu_item['enabled'])
                        <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                            {{ $menu_item['name'] ?? '' }}
                        </a>
                    @endif
                @endforeach
            @endif
        </nav>
        {{-- <form class="w-full flex md:ml-0" action="#" method="GET">
          <label for="search-field" class="sr-only">Search</label>
          <div class="hidden relative w-full text-gray-400 focus-within:text-gray-600">
            <div class="hiddenabsolute inset-y-0 left-0 flex items-center pointer-events-none">
              <!-- Heroicon name: solid/search -->
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search" type="search" name="search">
          </div>
        </form> --}}
      </div>
      {{-- Top bar --}}
      <div class="ml-4 flex items-center md:ml-6">
          <livewire:global.user-top-bar></livewire:global.user-top-bar>
      </div>
    </div>
  </div>
