@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ translate('All products') }}</h5>
            <a href="{{ route('ev-products.create') }}" class="btn btn-primary btn-xs">{{ translate('Add new') }}</a>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                <thead class="thead-light">
                <tr>
                    <th>{{ translate('Thumb') }}</th>
                    <th>{{ translate('Name') }}</th>
                    <th>{{ translate('Category') }}</th>
                    <th>{{ translate('Base Price') }}</th>
                    <th>{{ translate('Published') }}</th>
                    <th>{{ translate('Options') }}</th>
                </tr>
                </thead>
                <tbody>

                @if(!empty($products))
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <a href="{{ route('ev-products.edit', $product->slug) }}">
                                    <img class="avatar avatar-sm avatar-circle mr-3 border" src="{{ $product->getThumbnail(['w' => 60]) }}" alt="{{ $product->name }}">
                                </a>
                            </td>
                            <td><a href="{{ route('ev-products.edit', $product->slug) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->selected_categories()->first()->name ?? '' }}</td>
                            <td>{{ single_price($product->unit_price) }}</td>
                            <td>
                                <label class="toggle-switch d-flex align-items-center " for="customSwitch2">
                                    <input type="checkbox" class="toggle-switch-input" id="customSwitch2" checked>
                                    <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                  </span>
                                </label>
                            </td>
                            <td>
                                <a class="btn btn-soft-info btn-icon btn-circle btn-xs" href="{{ route('ev-products.edit', $product->slug) }}">
                                    @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;'])
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-xs confirm-delete" href="javascript:void(0)">
                                    @svg('heroicon-o-trash', ['style' => 'height: 16px;'])
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
            <hr>
            <div class="text-center d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
        <!-- End Table -->
    </div>
    <!-- End Card -->
@endsection
