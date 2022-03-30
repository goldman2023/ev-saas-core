@extends('frontend.layouts.app')

@section('content')

<section class="container">
    <!-- Features Section -->
    <div class="grid grid-cols-3 space-2 gap-20">
        <div class="col-span-3">
            @livewire('onboarding.elements.shop-setup')

        </div>

        <div class="col-span-1">

        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
