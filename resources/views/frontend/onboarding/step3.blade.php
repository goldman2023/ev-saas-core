@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div class="col-span-3 bg-gray-100 p-3">
    <livewire:onboarding.elements.steps step="2">
    </livewire:onboarding.elements.steps>
</div>
<section class="container py-10">
    <!-- Features Section -->
    <div class="grid grid-cols-3 space-2 gap-20">

        <div class="col-span-2">
            <livewire:dashboard.forms.settings.my-shop-form :onboarding="true"></livewire:dashboard.forms.settings.my-shop-form>

        </div>

        <div class="col-span-1">
            <x-default.elements.support-card></x-default.elements.support-card>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
