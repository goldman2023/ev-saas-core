@if(!auth()->user()->subscribed())
<!-- CTA -->
{{-- TODO: Make background image dynamice --}}
<div class="bg-img-hero rounded-lg p-6 bg-dark text-white"
    style="">
    <div class="row align-items-md-center">
        <div class="col-md-8 mb-3 mb-md-0">
            <h1 class="h4 text-white">
                {{ translate('Upgrade your '. get_site_name() .' profile, to your own e-commerce store!') }}
            </h1>
            <h3 class="h5 text-white">
                {{ translate('Starting from 89€/month') }}
            </h3>
        </div>
        <div class="col-md-4 text-md-right">

            <a class="btn btn-primary btn-pill transition-3d-hover px-5" target="_blank"
            href="dashboard/subscriptions">
                {{ translate('Subscribe') }}
            </a>
        </div>
    </div>
</div>
@endif
<!-- End CTA -->
