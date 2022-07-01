@if(!empty($header_menu_items) && $header_menu_items->isNotEmpty())
@foreach($header_menu_items as $menu_item)
    @if($menu_item['enabled'])
        <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
            {{ $menu_item['name'] ?? '' }}
        </a>
    @endif
@endforeach
@endif
