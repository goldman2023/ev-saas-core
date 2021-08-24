@extends('frontend.layouts.app')

@section('content')
    <div class="relative min-h-screen bg-gray-100">
        <main class="pt-10 pb-8">
            <div class="max-w-xl"></div>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="sr-only">Profile</h1>
                <!-- Main 3 column grid -->
                <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-4 lg:gap-8">
                    <div class="grid grid-cols-1 gap-1">
                        <x-tenant.dashboard.user-menu></x-tenant.dashboard.user-menu>
                    </div>

                    <!-- Left column -->
                    <div class="grid grid-cols-1 gap-4 lg:col-span-3">

                        <h1> {{ translate('Products') }} </h1>
                        <livewire:datatable model="App\Models\Product" :exclude="['video_link', 'description', 'user_id']"/>
                    </div>

                    <!-- Right column -->
                    <div class="grid grid-cols-1 gap-4">



                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
