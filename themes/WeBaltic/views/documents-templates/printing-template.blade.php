@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')

<div class="padding: 80px;">
    <div style="-webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    text-align: center;
    -ms-transform: rotate(-90deg);
    transform: rotate(-90deg);
    transform: scale(0.6);
    ">
    @foreach($orders as $order)
        <x-dashboard.orders.order-details-card :print="true" :order="$order">
        </x-dashboard.orders.order-details-card>
    @endforeach
    </div>
</div>


@endsection
