@extends('frontend.layouts.app')

@section('content')

<section class="container">
    <!-- Features Section -->
    <div class="grid grid-cols-3 space-2 gap-20">
        <div class="col-span-2">
            @livewire('onboarding.elements.shop-setup')

        </div>

        <div class="col-span-1">
            <x-default.elements.support-card></x-default.elements.support-card>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
