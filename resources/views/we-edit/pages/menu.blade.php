<x-we-edit.layouts.one>
    @php
        $available_pages = \App\Models\Page::all();
        $positions['x'] = 0;
        $positions['y'] = 200;
        $count = 0;
        foreach ($available_pages as $page) {
            $count++;
            $page['data'] = ['label' => $page->title];
            $page->type = 'default';
            $page->type = 'system';
            $page['position'] = ['x' =>  $positions['x'], 'y' => $positions['y']];
            $positions['x'] += 200;
        }
        $menu_flow = [];

        $pages = [];

        $weEditData = [
            'pages' => json_encode($pages),
            'available_pages' => json_encode($available_pages),
            'menu_flow' => json_encode($menu_flow)
        ];
    @endphp
    <x-we-edit.flow.base :weEditData="$weEditData"></x-we-edit.flow.base>
</x-we-edit.layouts.one>