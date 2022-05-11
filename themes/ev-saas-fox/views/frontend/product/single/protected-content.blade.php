@extends('frontend.layouts.' . $globalLayout)

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('content')
labas
<div class="bg-gray-100">
    <div class="container  mt-[200px]">
        <x-default.products.recently-viewed-products class="p-3"></x-default.products.recently-viewed-products>
    </div>
</div>



@endsection
