<div class="row">
    <div class="col-8">
        <h3>
            {{ translate('New Members') }}
        </h3>
    </div>
    <div class="col-4 text-right">
    <a href="{{ route('sellers') }}">{{ translate('Explore All Members >') }}</a>
    </div>
</div>

@php
$companies = App\Models\Shop::whereIn('user_id', verified_sellers_id())
    ->orderBy('created_at', 'DESC')
    ->take('3')
    ->get();
@endphp
<div class="row align-content-stretch mb-7">

    @foreach ($companies as $key => $company)
        <div class="col-lg-4 mb-3">
            <x-company.company-card :company="$company" new="true"></x-company.company-card>
        </div>
    @endforeach
</div>
