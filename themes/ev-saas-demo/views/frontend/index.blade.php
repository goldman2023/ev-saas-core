@extends('frontend.layouts.app')

@section('content')
    <section id="archive-hero">
        <x-companies-archive-hero categoryTitle="Find Partners"></x-companies-archive-hero>
    </section>
    <section id="homepage-stats">
        @php
            $categories = App\Models\Category::where('level', 0)
                ->orderBy('order_level', 'desc')
                ->get();
        @endphp
        <x-category-list :categories="$categories"></x-category-list>
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
@endsection


