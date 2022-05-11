@extends('frontend.layouts.app')

@section('content')

    @if($preview->type === 'wysiwyg')
        <div class="container py-10">
            {!! $preview->content !!}
        </div>
    @elseif($preview->type === 'html')
        <div class="w-full">
            {!! $preview->content !!}
        </div>
    @elseif($preview->type === 'system')
    @else
        @if(!empty($sections))
            @foreach ($sections as $key => $section)
                @if($section['id'] === 'html' && !empty($section['html'] ?? null))
                    {!! $section['html'] !!}
                @else
                    <x-dynamic-component :component="$section['id'] ?? ''" 
                        :we-data="$section['data'] ?? []"
                        :settings="$section['settings'] ?? []" 
                        {{-- :uuid="$section['uuid'] ?? ''" --}}
                        class="mt-4" />
                @endif
                
            @endforeach
        @endif
    @endif

@endsection
