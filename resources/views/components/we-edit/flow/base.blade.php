<div class="App">
    <div id="root"></div>
    <div id="info-box">
        This is an info box
    </div>
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
            'pages' => json_encode($available_pages),
            'available_pages' => json_encode($available_pages),
            'menu_flow' => json_encode($menu_flow)
        ];
    @endphp
     <script>
        var server_data = {!! $weEditData['pages'] !!};
        var available_pages = {!! $weEditData['available_pages'] !!};
        var menu_flow = {!! $weEditData['menu_flow'] !!};
        console.info("Server data: ");
        console.log(server_data);
        console.info("Menu Flow data: ");
        console.log(menu_flow);

        console.info("Available pages data: ");
        console.log(available_pages);
    </script>
    <h1> We Flow </h1>
    <script src="{{ static_asset('we-edit/index.js', false, true, true) }}"></script>

</div>
