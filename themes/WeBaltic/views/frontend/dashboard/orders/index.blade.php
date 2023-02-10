@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Orders'))

@push('head_scripts')

@endpush

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('All orders') }}" text="">
    <x-slot name="content">
        <a href="{{ route('order.create') }}" class="btn-primary">

            <span>{{ translate('Add new') }}</span>
            @svg('heroicon-o-plus', ['class' => 'h-4 h-4 ml-2'])
        </a>
    </x-slot>
</x-dashboard.section-headers.section-header>

<div class="-mt-6 mb-6">
    {{ Breadcrumbs::render('dashboard.orders') }}
</div>


<div class="w-full" x-cloak>
    @if($orders_count > 0)

        <livewire:dashboard.tables.tabs.tabs-header
            tabs-id="orders"
            :is-wef="true"
            property="cycle_status"
            :enum-class="\WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum::class"
            :model-class="\App\Models\Order::class">

        <div id="orders-tabs">
            @foreach(\WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum::values() as $key => $status)
                <div id="orders-tab-{{ $key }}" role="tabpanel" aria-labelledby="order-nav-{{ $key }}"
                    class="">
                    <div class="sm:grid grid-cols-12 gap-6">
                        <div class="sm:col-span-9">
                            <livewire:dashboard.tables.orders-table :status="$key" table-id="orders-table-{{ $status }}">
                            </livewire:dashboard.tables.orders-table>
                        </div>
                        <div class="sm:col-span-3">
                            @if(auth()->user()->isAdmin())
                                <livewire:dashboard.tables.action-panels.orders-action-panel table-id="orders-table-{{ $status }}" />
                            @else
                                <x-dashboard.elements.support-card class="card bg-white p-4 mb-3">
                                </x-dashboard.elements.support-card>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    @else
        <x-dashboard.empty-states.no-items-in-collection icon="heroicon-o-document" title="{{ translate('No orders yet') }}"
            text="{{ translate('Engage your customers so you can get a new order!') }}">

        </x-dashboard.empty-states.no-items-in-collection>
    @endif

    {{-- <div class="col-6">
        <x-default.dashboard.widgets.create-card></x-default.dashboard.widgets.create-card>
    </div>

    <div class="col-6">
        <x-default.dashboard.widgets.create-card title="Create a subscription product"
            description="Create a recurring digital product"></x-default.dashboard.widgets.create-card>
    </div> --}}
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
