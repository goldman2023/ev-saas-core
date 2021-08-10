 @if (\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Models\Addon::where('unique_identifier', 'seller_subscription')->first()->activated)

     <div class="card">
         <div class="card-header">
             <h6 class="mb-0">{{ translate('Your B2BWood Club Membership') }}</h6>
         </div>
         @php
             $seller_package = \App\Models\SellerPackage::find(auth()->user()->seller->seller_package_id);
         @endphp
         <div class="card-body text-center">
             @if ($seller_package != null)
                 <img src="{{ uploaded_asset($seller_package->logo) }}" class="img-fluid mb-4 h-110px">
                 {{-- <p class="mb-1 text-muted">{{ translate('Product Upload Remaining') }}:
                                {{ auth()->user()->seller->remaining_uploads }} {{ translate('Times') }}</p> --}}
                 {{-- <p class="text-muted mb-1">{{ translate('Digital Product Upload Remaining') }}:
                                {{ auth()->user()->seller->remaining_digital_uploads }} {{ translate('Times') }}</p> --}}
                 <p class="text-muted mb-4">{{ translate('Membership Expires at') }}:
                     {{ auth()->user()->seller->invalid_at }}</p>
                 <h6 class="fw-600 mb-3 text-primary">{{ translate('Current Membership') }}:
                     {{ $seller_package->name }}
                 </h6>
             @else
                 <h6 class="fw-600 mb-3 text-primary">{{ translate('Membership Not Found') }}</h6>
             @endif
             <div class="text-center">
                 <a href="{{ route('seller_packages_list') }}"
                     class="btn btn-soft-primary">{{ translate('Upgrade Membership') }}</a>
             </div>
         </div>
     </div>
 @endif

 <div class="card bg-white mt-4 p-4 text-center d-none">
     <div class="h5 fw-600">{{ translate('Payment') }}</div>
     <p>{{ translate('Configure your payment method') }}</p>
     <a href="{{ route('profile') }}" class="btn btn-soft-primary">{{ translate('Configure Now') }}</a>
 </div>
