@extends('frontend.layouts.app')

@section('content')

    <!-- Cart Section -->
    <div class="container space-2">
        <div class="w-md-80 w-lg-50 text-center mx-md-auto">
            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
            {{ svg('heroicon-s-shield-check', ['class' => ' text-success w-25 mb-3']) }}
            <div class="mb-5">
                <h1 class="h2">
                    <x-ev.label :label="ev_dynamic_translate('Thank You For Contacting Us', true)">
                    </x-ev.label>
                </h1>
                <p>
                    <x-ev.label :label="ev_dynamic_translate('Thank You For Description', true)">
                    </x-ev.label>
            </div>

            <x-ev.link-button :href="ev_dynamic_translate('#thank-you-page-button1', true)" :label="ev_dynamic_translate('Thank You Button', true)"
                class="btn btn-primary btn-pill transition-3d-hover px-5 ev-button">
            </x-ev.link-button>
        </div>
    </div>
    <!-- End Cart Section -->
@endsection
