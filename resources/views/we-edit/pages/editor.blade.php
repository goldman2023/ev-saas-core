<x-we-edit.layouts.three>
    <x-slot name="first_column">
        <livewire:we-edit.panels.available-sections />
    </x-slot>
    <x-slot name="second_column">
        <livewire:we-edit.panels.pages-editor />
    </x-slot>
    <x-slot name="third_column">
        <h2 class="w-full text-center text-18 py-2 bg-sky-500 text-white">{{ translate('Page Preview') }}</h2>


    </x-slot>
</x-we-edit.layouts.three>
