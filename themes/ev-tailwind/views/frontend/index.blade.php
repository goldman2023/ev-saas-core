@extends('frontend.layouts.app')

@section('content')
    <div class="container mx-auto">
        <x-tailwind.hero.ecommerce-hero></x-tailwind.hero.ecommerce-hero>
        <x-tailwind.product-lists.simple class="space-y-80"></x-tailwind.product-lists.simple>
    </div>
@endsection
