@extends('frontend.layouts.app')

@section('content')


<section class="overflow-hidden">
    <x-default.hero.software-hero></x-default.hero.software-hero>
</section>



{{-- TODO: Refactor this to blade components --}}
@include('frontend.components.benefits')

<section>
    {{-- <x-default.promo.features></x-default.promo.features> --}}
</section>

<section>
    <x-default.promo.reviews></x-default.promo.reviews>
</section>

@endsection

@section('script')

@endsection
