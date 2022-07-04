@extends('frontend.layouts.app')

@section('content')

@if($page->type === 'wysiwyg')
    <div class="container py-10">
        {!! $page->content !!}
    </div>
@elseif($page->type === 'html')
    <div class="w-full">
        {!! $page->content !!}
    </div>
@elseif($page->type === 'system')
    @if(!empty($page->template) && \File::exists(Theme::path($path = '/views/frontend/page-templates').'/'.$page->template.'.blade.php'))
        @include('frontend.page-templates.'.$page->template)
    @endif
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
