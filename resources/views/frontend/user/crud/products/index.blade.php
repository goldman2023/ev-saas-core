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
                    <th style="width: 5%;"></th>
                </tr>
                </thead>
                <tbody>

                @if(!empty($products))
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <a href="{{ route('ev-products.edit', $product->slug) }}">
                                    <img class="avatar avatar-sm avatar-circle mr-3" src="{{ $product->images['thumbnail']['url'] ?? '' }}" alt="{{ $product->name }}">
                                </a>
                            </td>
                            <td><a href="{{ route('ev-products.edit', $product->slug) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->category()->name ?? '' }}</td>
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
                        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
                            <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                        </svg>
                    </figure>

                    <div class="modal-close">
                        <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal" aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- End Header -->

                <div class="modal-top-cover-avatar">
                    <img class="avatar avatar-lg avatar-circle avatar-border-lg avatar-centered shadow-soft" src="../assets/svg/brands/front.svg" alt="Logo">
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
                                <img class="avatar avatar-xss mr-2" src="../assets/svg/brands/mastercard.svg" alt="Image Description">
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
                        <a class="btn btn-xs btn-white" href="#"><i class="fas fa-file-download mr-1"></i> PDF</a>
                        <span class="mx-1"></span>
                        <a class="btn btn-xs btn-white" href="#"><i class="fas fa-print mr-1"></i> Print Details</a>
                    </div>

                    <hr class="my-5">

                    <p class="modal-footer-text">If you have any questions, please contact us at <a href="mailto:example@gmail.com">example@gmail.com</a> or call at <a class="text-nowrap" href="#">+1 898 34-5492</a></p>
                </div>
                <!-- End Body -->
            </div>
        </div>
    </div>
    <!-- End Invoice Modal -->
@endsection
