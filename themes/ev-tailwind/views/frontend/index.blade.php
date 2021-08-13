@extends('frontend.layouts.app')

@section('content')
    <x-tenant.hero.simple-centered button="Labas"></x-tenant.hero.simple-centered>

    <x-tenant.product-list.with-inline-price></x-tenant.product-list.with-inline-price>
@endsection
