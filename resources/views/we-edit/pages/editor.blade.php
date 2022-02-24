<x-we-edit.layouts.three>
    <x-slot name="first_column">
        <livewire:we-edit.panels.available-sections />
    </x-slot>
    <x-slot name="second_column">

    </x-slot>
    <x-slot name="third_column">
        <h2>Preview </h2>
        @php
        $page = \App\Models\Page::where('slug', 'home')->first();
        $sections = $page->content;
        @endphp
        @if(!empty($sections))
        <div id="render-container" class="bg-white px-6 absolute top-[20px] left-0"
            style="max-height: 500px; overflow:hidden; overflow-y: scroll;">
            @foreach ($sections as $key => $section)
            <x-dynamic-component :component="$key" :dataOverides="$section['data']" class="mt-4" />
            @endforeach
        </div>
        @endif

    </x-slot>
</x-we-edit.layouts.three>
