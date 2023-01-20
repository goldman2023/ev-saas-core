@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')

<div>
    @foreach($orders as $order)
        <x-dashboard.orders.order-details-card :print="true" :order="$order">
        </x-dashboard.orders.order-details-card>
    @endforeach
</div>


@endsection
