@extends('frontend.layouts.app')

@section('content')
<livewire:onboarding.elements.steps current_step="1">
</livewire:onboarding.elements.steps>
<section class="container">
    <!-- Features Section -->
    <div class="grid grid-cols-3 space-2 gap-20">
        <div class="col-span-2">
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
