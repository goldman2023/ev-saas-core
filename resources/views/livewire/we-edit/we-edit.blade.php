@extends('frontend.layouts.user_panel')
@section('meta_title')
{{ translate('Page Builder') }}
@endsection
@section('panel_content')
<div id="we-edit" class="h-full w-full flex" x-data="{}">

    {{--
    <livewire:we-edit.navigation.sidebar :menu="$we_menu" /> --}}

    <div class=" overflow-hidden">

        <x-we-edit.layouts.three>
            <x-slot name="first_column">
                <livewire:we-edit.panels.available-sections />
            </x-slot>
            <x-slot name="second_column">
                <livewire:we-edit.panels.pages-editor />
            </x-slot>
            <x-slot name="third_column">
                <h2 class="w-full text-center text-18 py-2 bg-sky-500 text-white">{{ translate('Page Preview') }}</h2>
                <div class="w-full relative ">
                    {{-- TODO: Add dynamic page ID for preview --}}

                    <div id="we-mobile-preview" class="relative mt-3" style="z-index: 5; max-width: 360px; margin-left: 100px;">

                        <iframe src="{{ route('show') }}" class="relative"
                            style="margin-top: 100px; z-index: 1; width: 360px; min-height: 660px; border-left: 20px solid transparent; border-right: 20px solid transparent; "></iframe>

                        <img style="position: absolute; z-index: 9; top: 0; margin-top: -50px; left: 0; pointer-events: none;"
                            class="page-frame w-full" src="/assets/we-edit/img/phone-frame.png" alt="phone frame background" />
                    </div>

                    <div id="we-desktop-preview" class="shadow-lg"
                        style="z-index: 6; position: absolute; top: -100px; left: 0; transform: scale(0.5); margin-left: 200px;">
                        <iframe src="{{ route('show') }}" class="relative"
                            style="margin-top: 200px; z-index: 9; width: 1240px; min-height: 720px; border-left: 3px solid transparent; border-right: 3px solid transparent; "></iframe>
                        <img style="position: absolute; z-index: 1; top: 0; left: 0; pointer-events: none;"
                            class="page-frame w-full" src="/assets/we-edit/img/chrome-mac-light-frame.png"
                            alt="page frame background" />


                    </div>

                </div>

            </x-slot>
        </x-we-edit.layouts.three>

    </div>

    <livewire:we-media-library />
</div>
@endsection
