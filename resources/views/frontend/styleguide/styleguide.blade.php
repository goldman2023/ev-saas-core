@extends('frontend.layouts.app')

@section('content')
<h1> This is a styleguide list of all the components in the application. With usage examples</h1>

<section>
    <h2 class="h1"> Forms</h2>
    <livewire:forms.contact-form />

    <div>
        <code>
            <livewire:forms.contact-form />
        </code>
    </div>
</section>

{{-- TODO: Refactor this to blade components --}}
{{-- @include('frontend.components.news') --}}
@endsection

@section('script')

@endsection
