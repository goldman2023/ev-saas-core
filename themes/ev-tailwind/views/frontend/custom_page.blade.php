@extends('frontend.layouts.app')

@section('content')
@if(!empty($sections))
    @foreach ($sections as $key => $section)
    <x-dynamic-component :component="$section['id'] ?? ''" :we-data="$section['data'] ?? []"
        :settings="$section['settings'] ?? []" class="mt-4" />
    @endforeach
@endif

@endsection
