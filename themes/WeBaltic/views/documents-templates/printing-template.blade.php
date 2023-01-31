@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')

<div class="padding-top: 40px;">
    <div style="
    transform: rotate(90deg) scale(0.6);
    max-width: 700px;
    ">
    @foreach($orders as $order)
    <div style="margin-bottom: 10px; ">
        <x-dashboard.orders.order-details-card :print="true" :order="$order">
        </x-dashboard.orders.order-details-card>
    </div>
    @endforeach
    </div>
</div>


@endsection
