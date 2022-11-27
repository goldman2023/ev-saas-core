<nav class="grid gap-y-8">
    @if(!empty($menu) && $menu->isNotEmpty())
    @foreach($menu as $menu_item)
    @if($menu_item['enabled'])
    <a href="{{ $menu_item['value'] ?? '#' }}" target="{{ $menu_item['target'] ?? '_self' }}"
        class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
        {{ $menu_item['name'] ?? '' }}
        {{ json_encode($menu_item) }}
    </a>
    @endif
    @endforeach
    @endif
</nav>
