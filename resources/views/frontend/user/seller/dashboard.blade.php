@extends('frontend.layouts.user_panel')

@section('panel_content')
<section>
    <div class="row">
        <div class="grid">
            <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
        </div>
        <div class="grid grid-cols-4 gap-12 mb-12">

            <div class="lg:col-span-2 col-span-2">
                <x-dashboard.elements.support-card class="card mb-3">
                </x-dashboard.elements.support-card>
            </div>

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



            </div>

        </div>
    </div>
</section>



<section class="stats mb-3">
    <div class="grid grid-cols-2 gap-10">
        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>

<section>

</section>
@endsection
