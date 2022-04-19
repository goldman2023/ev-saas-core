@extends('frontend.layouts.app')

@section('content')
    @if(!empty($preview['content']))
        <div id="render-container" class="bg-white px-0 relative left-0 h-[calc(100vh_-_106px)] overflow-x-hidden overflow-y-auto"
            style="overflow:hidden; overflow-y: scroll;">
            @foreach ($preview['content'] as $key => $section)
                @if($section['id'] === 'html' && !empty($section['html'] ?? null))
                    {!! $section['html'] !!}
                @else
                    <x-dynamic-component :component="$section['id'] ?? ''" :we-data="$section['data'] ?? []" :settings="$section['settings'] ?? []" class="mt-4" />
                @endif
            @endforeach

            {{-- The preview rendering idealy should become like this --}}
            {{-- <x-dynamic-component :component="$section['id'] ?? ''" :dataOverides="$section['data'] ?? []" class="mt-4">
                @foreach($section['slots'] as $key $slot)
                    <x-slot :name="$key">
                        <x-dynamic-component :component="$section['id']['slots']['section_title']">
                        </x-dynamic-component>
                    </x-slot>
                @endforeach
            </x-dynamic-component> --}}

        </div>
    @endif
@endsection