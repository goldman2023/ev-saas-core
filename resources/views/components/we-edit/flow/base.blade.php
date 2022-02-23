<div class="App">
    <div id="root"></div>
    <div id="info-box">
        This is an info box
    </div>
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
</div>
<script src="{{ static_asset('we-edit/index.js', false, true, true) }}"></script>
