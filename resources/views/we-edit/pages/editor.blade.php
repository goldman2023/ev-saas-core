<x-we-edit.layouts.three>
    <x-slot name="first_column">
        <livewire:we-edit.panels.available-sections />
    </x-slot>
    <x-slot name="second_column">
        <livewire:we-edit.panels.pages-editor />
    </x-slot>
    <x-slot name="third_column">
        <h2 class="w-full text-center text-18 py-2 bg-sky-500 text-white">Page Preview </h2>

        @php
            $page = \App\Models\Page::where('slug', 'home')->first();
            $sections = $page->content;
        @endphp
        @if(!empty($sections))
        <div id="render-container" class="bg-white px-6 relative left-0 h-[calc(100vh_-_106px)] overflow-x-hidden overflow-y-auto"
            style="overflow:hidden; overflow-y: scroll;">
            @foreach ($sections as $key => $section)
                <x-dynamic-component :component="$key" :dataOverides="$section['data']" class="mt-4" />
            @endforeach
        </div>
        @endif

    </x-slot>
</x-we-edit.layouts.three>
