@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="grid grid-cols-3">
        <div class="col-span-1">
        </div>

        <div class="col-span-1">
        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="grid">
            <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
        </div>
        <div class="sm:grid sm:grid-cols-4 gap-5 gap-y-5 mb-12 grid">

         {{--    <div>
                <x-dashboard.widgets.top-categories></x-dashboard.widgets.top-categories>
            </div> --}}

            <div>
                <x-dashboard.elements.card>
                    <x-slot name="cardHeader" class="flow-root mt-6">
                        <div class="h5 fw-600">{{ translate('Products') }} </div>
                    </x-slot>
                    <x-slot name="cardBody" class="">
                        {{-- TODO : make this company name dynamic --}}
                        <p>{{ translate('Manage & organize your inventory and products') }}</p>

                    </x-slot>
                    <x-slot name="cardFooter">
                        <a href="{{ route('products.index') }}" class="btn btn-soft-primary">
                            {{ translate('Manage Products') }}
                        </a>
                    </x-slot>
                </x-dashboard.elements.card>
            </div>
            <div>

                <x-dashboard.elements.support-card class="card mb-3">
                </x-dashboard.elements.support-card>

            </div>

            <div>
                <x-dashboard.elements.card>
                    <x-slot name="cardHeader" class="flow-root mt-6">
                        <div class="h5 fw-600">{{ translate('Quick Actions') }} </div>
                    </x-slot>
                    <x-slot name="cardBody" class="">
                        {{-- TODO : make this company name dynamic --}}
                        <p>{{ translate('') }}</p>

                    </x-slot>
                    <x-slot name="cardFooter">
                        <div class="overflow-x-auto sm:flex lg:block">
                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary mb-3">
                                🚚 {{ translate('Process Orders') }}
                            </a>

                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary mb-3">
                                📄 {{ translate('Create manual invoice') }}
                            </a>

                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary mb-3">
                                📦 {{ translate('Manage Products') }}
                            </a>

                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary">
                                🏷️ {{ translate('Manage Categories') }}
                            </a>
                        </div>
                    </x-slot>
                </x-dashboard.elements.card>
            </div>

        </div>
    </div>
</section>



<section class="stats">
    <div class="grid sm:grid-cols-2 gap-5">
    {{--     <x-default.dashboard.widgets.integrations-widget>

        </x-default.dashboard.widgets.integrations-widget> --}}

        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>

        <div class="">
            <div class="">
                {{-- TODO: Implement propper scope for seller activity viewing --}}
                {{-- @livewire('dashboard.elements.activity-log', ['scope' => 'seller']) --}}
            </div>
        </div>
    </div>
</section>

<section>

</section>
@endsection
