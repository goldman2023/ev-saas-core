@extends('frontend.layouts.app')

@section('content')

<section>
    <x-default.brands.brands-list>
    </x-default.brands.brands-list>
</section>

@php
$categories = App\Models\Category::where('level', 0)
->orderBy('order_level', 'desc')
->get();
@endphp

<section class="overflow-hidden">
    <x-default.hero.product-hero></x-default.hero.product-hero>
    {{-- <x-default.promo.countdown></x-default.promo.countdown> --}}
</section>

<section>
    <div class="container">
                <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>

<section class="space-1">
    <x-default.products.product-list slider="true">
    </x-default.products.product-list>
</section>


<section>
    <x-default.companies.companies-list></x-default.companies.companies-list>
</section>

<section class="space-2">

    <x-default.products.product-list.with-category-icons :categories="$categories">
    </x-default.products.product-list.with-category-icons>
</section>




<section id="archive-hero">
    {{-- <x-companies-archive-hero></x-companies-archive-hero> --}}
</section>

<section>

    <x-default.categories.category-tabs-with-products :categories="$categories">
    </x-default.categories.category-tabs-with-products>
</section>

<section>
    @php
    $categories = App\Models\Category
    ::where('level', 0)
    ->orderBy('order_level', 'desc')
    ->get();
    @endphp
    <x-default.categories.category-list :categories="$categories" slider="true"> </x-default.categories.category-list>
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
