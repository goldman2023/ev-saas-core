@extends('frontend.layouts.user_panel')

@section('panel_content')
<section>
    <div class="row">
        <div class="grid">
            {{-- <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome> --}}
        </div>
        <div class="sm:grid sm:grid-cols-12 gap-12 mb-12">

            <div class="w-full col-span-8">

                <div class="mb-8">
                    <div class="text-4xl text-gray-900 font-bold mb-3">
                        {{ translate('My orders') }}
                    </div>
                    <div class="mb-8">
                        <x-dashboard.orders.customer-orders-table> </x-dashboard.orders.customer-orders-table>
                    </div>
                </div>
            </div>

            <div class="col-span-4">
                <x-dashboard.elements.support-card class="card bg-white p-4 mb-3">
                </x-dashboard.elements.support-card>
            </div>

        </div>
    </div>
</section>

<section class="recently-viewed-products mb-3">
    <div class="">
        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>
@endsection
