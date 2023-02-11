@extends('frontend.layouts.app')

@section('meta')
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@push('head_scripts')
<style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin-bottom: 15px;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="container pb-[60px]">
    <div class="grid grid-cols-12">
        <div class="col-span-6 gap-3 grid">
            <h1>Logo</h1>
            <img class="max-w-[500px]" src="{{ get_site_logo() }}" />
            <img class="max-w-[150px]" src="{{ get_site_logo() }}" />
            <img class="max-w-[64px]" src="{{ get_site_logo() }}" />
        </div>

        <div class="col-span-6">
            <div>
                <h1> Heading 1</h1>
                <h2> Heading 2</h2>
                <h3> Heading 3</h3>
                <h4> Heading 4</h4>
                <h5> Heading 5</h5>
                <h6> Heading 6</h6>
            </div>

            <div>
                <h2>Product Cards </h2>
            </div>
        </div>

        <div class="col-span-6">
            <h1> Color Pallete</h1>

            @php
            $colors = TenantSettings::get('colors')
            @endphp
            <h2>Primary Colors </h2>
            <div class="w-[50px] h-[50px] bg-[{{$colors['primary']}}]"></div>
        </div>

    </div>
</div>
@endsection
