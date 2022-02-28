@extends('frontend.layouts.app')

@section('content')
    @if(!empty($preview['content']))
        <div id="render-container" class="bg-white px-6 relative left-0 h-[calc(100vh_-_106px)] overflow-x-hidden overflow-y-auto"
            style="overflow:hidden; overflow-y: scroll;">
            @foreach ($preview['content'] as $key => $section)
                <x-dynamic-component :component="$section['id'] ?? ''" :dataOverides="$section['data'] ?? []" class="mt-4" />
            @endforeach
        </div>
    @endif
@endsection