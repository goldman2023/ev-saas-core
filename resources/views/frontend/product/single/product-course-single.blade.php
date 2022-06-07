@extends('frontend.layouts.'. $globalLayout)

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('feed_content')
    <div class="bg-white col-span-12 rounded-lg">
        <div class="mx-auto py-8 px-4 sm:py-18 sm:px-6 lg:max-w-7xl lg:px-4">
            <div class="grid grid-cols-12">

            </div>
        </div>
    </div>
@endsection
