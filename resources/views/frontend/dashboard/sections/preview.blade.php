@extends('frontend.layouts.app')

@section('content')

    @if(!empty($section) && !empty($section_content))
        <div id="section-{{ \UUID::generate(4)->string }}" class="border-y border-gray-300">
            {!! $section_content !!}
        </div>
    @endif

@endsection