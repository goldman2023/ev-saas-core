@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')
<div class="card">
    <div class="card-body">
        <h1> {{ $product->name }}</h1>

        <strong>{{ translate('Actions:') }}</strong>

        <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
            href="{{ route('product.single', $product->slug) }}" target="_blank">
            @svg('heroicon-o-eye', ['style' => 'height: 16px;', 'class' => 'mr-2'])
            {{ translate('Preview') }}
        </a>

        <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
            href="{{ route('ev-products.edit.stocks', $product->slug) }}">
            @svg('heroicon-o-archive', ['style' => 'height: 16px;', 'class' => 'mr-2'])
            {{ translate('Stock Management') }}
        </a>

        @if($product->useVariations())
        <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
            href="{{ route('ev-products.edit.variations', $product->slug) }}">
            @svg('heroicon-o-variable', ['style' => 'height: 16px;', 'class' => 'mr-2'])
            {{ translate('Variations') }}
        </a>
        @endif

        <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center"
            href="{{ route('ev-products.edit', $product->slug) }}">
            {{ translate('Edit') }} @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;', 'class' => 'ml-2'])
        </a>
        <a class="btn btn-soft-danger btn-circle btn-xs d-inline-flex align-items-center confirm-delete "
            href="javascript:void(0)">
            {{ translate('Delete') }} @svg('heroicon-o-trash', ['style' => 'height: 16px;', 'class' => 'ml-2'])
        </a>

        <div class="ev-product-preview mt-3">
            <div class="row">

                <div class="col-4" style="max-height: 400px;">
                    <h3>{{ translate('Product Preview') }} </h3>

                    <x-default.products.cards.product-card :product="$product">
                    </x-default.products.cards.product-card>
                </div>

                <div class="col-6">
{{--                    <!-- Leaflet (Map) -->--}}
{{--                    Map--}}
{{--                    <div id="map" class="leaflet-custom" class="min-h-450rem rounded" data-hs-leaflet-options='{--}}
{{--                      "map": {--}}
{{--                        "scrollWheelZoom": false,--}}
{{--                        "coords": [37.4040344, -122.0289704]--}}
{{--                      },--}}
{{--                      "marker": [--}}
{{--                        {--}}
{{--                          "coords": [37.4040344, -122.0289704],--}}
{{--                          "icon": {--}}
{{--                            "iconUrl": "../../assets/svg/components/map-pin.svg",--}}
{{--                            "iconSize": [50, 45]--}}
{{--                          },--}}
{{--                          "popup": {--}}
{{--                            "text": "Test text!"--}}
{{--                          }--}}
{{--                        }--}}
{{--                      ]--}}
{{--                     }'></div>--}}
                    <!-- End Leaflet (Map) -->
                    <h3>{{ translate('Product Stats') }} </h3>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <!-- Card -->
                            <div class="card card-bordered shadow-none h-100">
                                <div class="card-body">
                                    <h6 class="font-weight-normal mb-1">{{ translate("Product views") }}:</h6>
                                    <h4 class="card-title">{{ $product->public_view_count() }}</h4>
                                </div>
                            </div>
                            <!-- End Card -->
                        </div>

                        <div class="col-12 mb-3">
                            <!-- Card -->
                            <div class="card card-bordered shadow-none h-100">
                                <div class="card-body">
                                    <h6 class="font-weight-normal mb-1">{{ translate('Product Categories') }}:</h6>
                                    <h4 class="card-title">
                                        @foreach($product->categories()->get() as $category)
                                        <span class="badge badge-soft-primary p-2 mb-2">
                                            {{ $category->name }}
                                        </span>
                                        @endforeach
                                        {{-- Assign Categories button --}}
                                        <div class="mt-3">
                                            <small>
                                                <a href="{{ route('ev-products.edit', $product->slug) }}"
                                                    target="_blank"> {{ translate('+ Assign Categories') }} </a>
                                            </small>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            <!-- End Card -->
                        </div>

                        <div class="col-12 mb-3">
                            <!-- Card -->
                            <div class="card card-bordered shadow-none h-100">
                                <div class="card-body">
                                    <h6 class="font-weight-normal ">{{ translate("Price and Stock Management") }}</h6>
                                    <h4 class="card-title">
                                        <div>
                                            {{ translate('Current Stock: ')}} {{ $product->current_stock}}
                                        </div>
                                        <div class="mb-3">
                                            <small>
                                                <a href="{{ route('ev-products.edit.stocks', $product->slug) }}">
                                                    {{ translate('+ Manage Stock') }}
                                                </a>
                                            </small>
                                        </div>


                                        <div>

                                            <span
                                                class="badge badge-soft-success mr-2 w-auto d-flex align-items-center mb-3">
                                                {{ svg('heroicon-o-check', ['class' => 'ev-icon__xs text-success
                                                mr-2']) }}
                                                {{translate('Has Serial Numbers') }}
                                            </span>
                                        </div>

                                        <div>
                                            @if($product->useVariations())
                                            <span
                                                class="badge badge-soft-success mr-2 w-auto d-flex align-items-center">
                                                {{ svg('heroicon-o-check', ['class' => 'ev-icon__xs text-success
                                                mr-2']) }}
                                                {{translate('Variable Product') }}
                                            </span>
                                            @endif


                                    </h4>
                                </div>
                            </div>
                            <!-- End Card -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>

            {{-- Product orders --}}
            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header">
                            <h5 class="card-header-title">Order history</h5>
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Reference</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Updated</th>
                                        <th>Invoice</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#">#3682303</a></td>
                                        <td><span class="badge badge-soft-warning">Pending</span></td>
                                        <td>$264</td>
                                        <td>22/04/2020</td>
                                        <td><a class="btn btn-xs btn-white" href="#"><i
                                                    class="fas fa-file-download mr-1"></i> PDF</a></td>
                                        <td><a class="btn btn-xs btn-white" href="javascript:;" data-toggle="modal"
                                                data-target="#invoiceReceiptModal"><i class="fas fa-eye mr-1"></i> Quick
                                                view</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#2333234</a></td>
                                        <td><span class="badge badge-soft-success">Successful</span></td>
                                        <td>$264</td>
                                        <td>22/04/2019</td>
                                        <td><a class="btn btn-xs btn-white" href="#"><i
                                                    class="fas fa-file-download mr-1"></i> PDF</a></td>
                                        <td><a class="btn btn-xs btn-white" href="javascript:;" data-toggle="modal"
                                                data-target="#invoiceReceiptModal"><i class="fas fa-eye mr-1"></i> Quick
                                                view</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#9834283</a></td>
                                        <td><span class="badge badge-soft-success">Successful</span></td>
                                        <td>$264</td>
                                        <td>22/04/2018</td>
                                        <td><a class="btn btn-xs btn-white" href="#"><i
                                                    class="fas fa-file-download mr-1"></i> PDF</a></td>
                                        <td><a class="btn btn-xs btn-white" href="javascript:;" data-toggle="modal"
                                                data-target="#invoiceReceiptModal"><i class="fas fa-eye mr-1"></i> Quick
                                                view</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->
                    </div>
                    <!-- End Card -->

                    <!-- Invoice Modal -->
                    <div class="modal fade" id="invoiceReceiptModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <!-- Header -->
                                <div class="modal-top-cover bg-primary text-center">
                                    <figure class="position-absolute right-0 bottom-0 left-0">
                                        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px"
                                            y="0px" viewBox="0 0 1920 100.1">
                                            <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z" />
                                        </svg>
                                    </figure>

                                    <div class="modal-close">
                                        <button type="button" class="btn btn-icon btn-sm btn-ghost-light"
                                            data-dismiss="modal" aria-label="Close">
                                            <svg width="16" height="16" viewBox="0 0 18 18"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor"
                                                    d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- End Header -->

                                <div class="modal-top-cover-avatar">
                                    <img class="avatar avatar-lg avatar-circle avatar-border-lg avatar-centered shadow-soft"
                                        src="../assets/svg/brands/front.svg" alt="Logo">
                                </div>

                                <!-- Body -->
                                <div class="modal-body pt-3 pb-sm-5 px-sm-5">
                                    <div class="text-center mb-5">
                                        <h3 class="mb-1">Invoice from Front</h3>
                                        <span class="d-block">Invoice #3682303</span>
                                    </div>

                                    <div class="row mb-6">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <small class="text-cap">Amount paid:</small>
                                            <span class="text-dark">$316.8</span>
                                        </div>

                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <small class="text-cap">Date paid:</small>
                                            <span class="text-dark">April 22, 2020</span>
                                        </div>

                                        <div class="col-md-4">
                                            <small class="text-cap">Payment method:</small>
                                            <div class="d-flex align-items-center">
                                                <img class="avatar avatar-xss mr-2"
                                                    src="../assets/svg/brands/mastercard.svg" alt="Image Description">
                                                <span class="text-dark">•••• 4242</span>
                                            </div>
                                        </div>
                                    </div>

                                    <small class="text-cap mb-2">Summary</small>

                                    <ul class="list-group mb-4">
                                        <li class="list-group-item text-dark">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Payment to Front</span>
                                                <span>$264.00</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item text-dark">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Tax fee</span>
                                                <span>$52.8</span>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-light text-dark">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>Amount paid</strong>
                                                <strong>$316.8</strong>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-xs btn-white" href="#"><i
                                                class="fas fa-file-download mr-1"></i> PDF</a>
                                        <span class="mx-1"></span>
                                        <a class="btn btn-xs btn-white" href="#"><i class="fas fa-print mr-1"></i> Print
                                            Details</a>
                                    </div>

                                    <hr class="my-5">

                                    <p class="modal-footer-text">If you have any questions, please contact us at <a
                                            href="mailto:example@gmail.com">example@gmail.com</a> or call at <a
                                            class="text-nowrap" href="#">+1 898 34-5492</a></p>
                                </div>
                                <!-- End Body -->
                            </div>
                        </div>
                    </div>
                    <!-- End Invoice Modal -->
                </div>
            </div>


        </div>
    </div>
</div>
@endsection

@push('footer_scripts')

@endpush
