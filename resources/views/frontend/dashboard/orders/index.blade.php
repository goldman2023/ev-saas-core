@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Orders'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('All orders') }}" text="">
    <x-slot name="content">
        <a href="{{ route('order.create') }}" class="btn-primary">
            @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
            <span>{{ translate('Add new') }}</span>
        </a>
    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="w-full">

    @if($orders_count > 0)
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
            role="tablist">
            <li class="mr-2" role="presentation">
                <button
                    class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                    id="new-orders" data-tabs-target="#new-orders-tab" type="button" role="tab" aria-controls="new-orders"
                    aria-selected="true">
                    {{ translate('New') }} ({{ \App\Models\Order::count() }})
                </button>
            </li>
        </ul>
    </div>
    <div id="myTabContent">
        <div class="bg-gray-50 rounded-lg dark:bg-gray-800" id="new-orders-tab" role="tabpanel"
            aria-labelledby="new-orders">
            <livewire:dashboard.tables.orders-table for="shop"></livewire:dashboard.tables.orders-table>


        </div>
    </div>
    @else

    <x-dashboard.empty-states.no-items-in-collection icon="heroicon-o-document" title="{{ translate('No orders yet') }}"
        text="{{ translate('Engage your customers so you can get a new order!') }}">

    </x-dashboard.empty-states.no-items-in-collection>
    @endif

</div>

<div class="hidden w-full grid grid-cols-12 gap-4 mt-5">
    <div class="col-span-12 md:col-span-6 lg:col-span-4 flex">
        <div class="shadow rounded border border-gray-200 bg-white p-4 w-full mb-3">
            <a href="{{ route('order.create') }}" class="flex flex-col">
                <div class="pb-2">
                    @svg('lineawesome-file-invoice-solid', ['class' => 'w-[32px] h-[32px]'])
                </div>
                <h5 class="text-20">
                    {{ translate('Create Order') }}
                </h5>
                <p class="text-dark text-14 mb-4">
                    {{ translate('Create full order manually.') }}
                </p>
                <span class="text-link flex items-center mt-auto">
                    {{ translate('Get Started') }}
                    @svg('heroicon-s-arrow-long-right', ['class' => 'w-[16px] h-[16px] ml-2'])
                </span>
            </a>
        </div>
    </div>
    <div class="col-span-12 md:col-span-6 lg:col-span-4 flex">
        <div class="shadow rounded border border-gray-200 bg-white p-4 w-full mb-3">
            <a href="#" class="flex flex-col">
                <div class="pb-2">
                    @svg('lineawesome-question-solid', ['class' => 'w-[32px] h-[32px]'])
                </div>
                <h5 class="text-20">
                    {{ translate('Create Proposal') }}
                </h5>
                <p class="text-dark text-14 mb-4">
                    {{ translate('Create order as a proposal for possible future payments.') }}
                </p>
                <span class="text-link flex items-center mt-auto">
                    {{ translate('Get Started') }}
                    @svg('heroicon-s-arrow-long-right', ['class' => 'w-[16px] h-[16px] ml-2'])
                </span>
            </a>
        </div>
    </div>
</div>

@endsection

@push('footer_scripts')

@endpush
