@extends('frontend.layouts.app')

@section('content')

@if(!empty($sections))
    @foreach ($sections as $key => $section)
        <x-dynamic-component :component="$section['id']" :dataOverides="$section['data']" class="mt-4" />
    @endforeach
@endif

@endsection
