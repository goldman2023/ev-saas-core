@extends('frontend.layouts.app')

@section('content')
    <h1> This is a styleguide list of all the components in the application. With usage examples </h1>














    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.benefits')

    @guest
        <section>
            <x-default.forms.contact-form></x-default.forms.contact-form>
        </section>
    @endguest
    {{-- TODO: Refactor this to blade components --}}
    {{-- @include('frontend.components.news') --}}
@endsection

@section('script')

@endsection
