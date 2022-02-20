@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')
<!-- Card -->
<div class="card">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title">{{ translate('All products') }}</h5>
        <a href="{{ route('product.create') }}" class="btn btn-primary btn-xs">{{ translate('Add new') }}</a>
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="card-body">
        <livewire:dashboard.tables.products-table></livewire:dashboard.tables.products-table>
    </div>
    <!-- End Table -->
</div>
<!-- End Card -->

<div class="row mt-3">
    <div class="col-6">
        <x-default.dashboard.widgets.create-card></x-default.dashboard.widgets.create-card>
    </div>

    <div class="col-6">
        <x-default.dashboard.widgets.create-card title="Create a subscription product" description="Create a recurring digital product"></x-default.dashboard.widgets.create-card>
    </div>
</div>
@endsection
