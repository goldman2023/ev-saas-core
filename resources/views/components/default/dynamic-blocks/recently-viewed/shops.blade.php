@if($shops->count() > 0)
<div class="card mt-3 mb-3">
    <div class="card-header">

        <h5>
            {{ translate('Recently Viewed Shops') }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row flex-nowrap ev-horizontal-slider" style="overflow: scroll;">
            @foreach($shops as $shop)

            @php
            $shop = $shop->subject;
            @endphp

            @if($shop)
            <div class="col-10 col-sm-4 mb-3">
                <x-company.company-card :company="$shop">
                </x-company.company-card>
            </div>
            @endif
            @endforeach
        </div>


    </div>
</div>
@endif
