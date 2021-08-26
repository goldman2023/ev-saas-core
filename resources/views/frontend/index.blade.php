@extends('frontend.layouts.app')

@section('content')
    <section id="archive-hero">
        <x-companies-archive-hero></x-companies-archive-hero>
    </section>

    <section>
        <x-default.categories.category-list> </x-default.categories.category-list>
    </section>

    <section>
        <x-default.reviews.reviews-list-detailed> </x-default.reviews.reviews-list-detailed>
    </section>

    <section id="homepage-stats">
        {{-- <x-homepage-stats></x-homepage-stats> --}}
    </section>

    <section id="homepage-stats">
        @php
            $categories = App\Models\Category::where('level', 0)
                ->orderBy('order_level', 'desc')
                ->get();
        @endphp
        <x-category-list :categories="$categories"></x-category-list>
    </section>

    {{-- TODO: Add latest companies list here --}}
    {{-- HERE --}}
    {{-- END TODO --}}

    <section id="b2b-new-companies">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {{-- <x-b2b-new-companies></x-b2b-new-companies> --}}
                </div>
            </div>
        </div>
    </section>

    <section id="b2b-new-products">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <x-latest-products></x-latest-products>
                </div>
            </div>
        </div>
    </section>
    <section id="global-companies-map">
        <div class="container">
            <div class="row flex-lg-nowrap">
                <div class="col-sm-4">
                    {{-- <x-credit-report-box></x-credit-report-box> --}}

                </div>
                <div class="col-sm-8">

                </div>
            </div>
        </div>
    </section>

    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.benefits')

    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.news')
@endsection

@section('script')

@endsection
