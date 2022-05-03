@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div class="col-span-3 bg-gray-100 p-3">
    <div class="container">
        <livewire:onboarding.elements.steps-progress current_step="2">
        </livewire:onboarding.elements.steps-progress>
    </div>

</div>
<section class="container py-10">
    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 space-2 gap-10">

        <div class="col-span-1 md:col-span-2">
            {{-- <livewire:dashboard.forms.settings.my-shop-form :onboarding="true"></livewire:dashboard.forms.settings.my-shop-form> --}}
            <livewire:dashboard.forms.settings.my-work-and-education-form :onboarding="true"></livewire:dashboard.forms.settings.my-work-and-education-form>

            <button type="button" class="btn btn-primary w-full !text-lg !p-3" @click="$dispatch('submit-form')">
                {{ translate('Complete') }}
            </button>
        </div>

        <div class="col-span-1">
            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mb-4" x-data="{}">
                <button type="button" class="btn btn-primary w-full" @click="$dispatch('submit-form')">
                    {{ translate('Complete') }}
                </button>
            </div>

            <x-default.elements.support-card></x-default.elements.support-card>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
