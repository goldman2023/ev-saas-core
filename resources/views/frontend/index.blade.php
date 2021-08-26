@extends('frontend.layouts.app')

@section('content')

<section>
    <x-default.hero.product-hero></x-default.hero.product-hero>
</section>

<section>
    <x-default.forms.contact-form></x-default.forms.contact-form>
</section>

    <section id="archive-hero">
        {{-- <x-companies-archive-hero></x-companies-archive-hero> --}}
    </section>

    <section>
        @php
        $categories = App\Models\Category::where('level', 0)
            ->orderBy('order_level', 'desc')
            ->get();
    @endphp
        <x-default.categories.category-list :categories="$categories"> </x-default.categories.category-list>
    </section>



    {{-- TODO: Add latest companies list here --}}
    {{-- HERE --}}
    {{-- END TODO --}}



    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {{-- <x-latest-products></x-latest-products> --}}
                </div>
            </div>
        </div>
    </section>


    {{-- TODO: Refactor this to blade components --}}
    @include('frontend.components.benefits')

    {{-- TODO: Refactor this to blade components --}}
    {{-- @include('frontend.components.news') --}}
@endsection

@section('script')

@endsection
