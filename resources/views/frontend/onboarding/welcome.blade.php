@extends('frontend.layouts.app')

@section('content')
<div class="col-span-3 bg-gray-100 py-3 mb-6">
    <div class="container">

        <livewire:onboarding.elements.steps-progress step="1">
        </livewire:onboarding.elements.steps-progress>
    </div>
</div>
<section class="container">
    <!-- Features Section -->
    <div class="grid grid-cols-1 space-2 gap-20 md:grid-cols-3">
        <div class="sm:col-span-2">
            @livewire('onboarding.elements.category-suggestion-list')

        </div>

        <div class="col-span-1">
            <x-default.elements.support-card></x-default.elements.support-card>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
