<!-- Team Section -->
<div class="container space-2">
    <!-- Title -->
    <div class="w-md-80 w-lg-60 text-center mx-md-auto mb-5 mb-md-9">
        <x-ev.label tag="span"  class="d-block small font-weight-bold text-cap mb-2" :label="ev_dynamic_translate('Companies List Sub-Title', true)">
        </x-ev.label>
        <x-ev.label tag="h2" :label="ev_dynamic_translate('Companies List Title', true)">
        </x-ev.label>
    </div>
    <!-- End Title -->

    <div class="row mx-n2 mb-5">
        @php
            $companies = App\Models\Shop
                ::orderBy('created_at', 'DESC')
                ->take('5')
                ->get();
        @endphp
        @foreach ($companies as $company)
            <div class="col-sm-6 col-lg-4 px-2 mb-3">
                <!-- Team -->
                <x-default.companies.cards.company-card :company="$company">
                </x-default.companies.cards.company-card>
                <!-- End Team -->
            </div>
        @endforeach

    </div>

    <!-- Info -->
    <div class="text-center">
        <div class="d-inline-block font-size-1 border bg-white text-center rounded-pill py-3 px-4">

            {{ translate('Want to be a part of us?') }}
            <a class="font-weight-bold ml-3" href="{{ route('shops.create') }}">
                {{ translate('Register as a Dealer') }}
                <span
                    class="fas fa-angle-right fa-sm ml-1"></span></a>
        </div>
    </div>
    <!-- End Info -->
</div>
<!-- End Team Section -->