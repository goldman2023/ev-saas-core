@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ $product->meta_title }}@stop

@section('meta_description'){{ $product->meta_description }}@stop

@section('meta_keywords'){{ $product->tags }}@stop

@section('meta')
    <x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('content')

@endsection
