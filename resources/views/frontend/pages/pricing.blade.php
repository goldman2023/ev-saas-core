@extends('frontend.layouts.app')

@section('content')
    @php
    $plans = App\Models\SellerPackage::all();
    @endphp
    <div class="overflow-hidden space-bottom-2">
        <h1 class="display-1">
            {{ translate('Pricing') }}
        </h1>
    </div>
@endsection

@section('script')

@endsection
