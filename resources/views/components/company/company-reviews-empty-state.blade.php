<div class="row justify-content-sm-center text-center">
    <div class="col-sm-7 col-md-5">
        <img class="img-fluid mb-5" style="width: 300px;"
            src="https://htmlstream.com/front-dashboard/assets/svg/illustrations/graphs.svg" alt="Image Description"
            style="max-width: 21rem;">

        <h1>{{ translate('No Reviews so far') }}</h1>
        <p>{{ translate('Be the first one to leave a review') }}</p>
        <a class="btn btn-primary"
            href="{{ route('reviews.create', $shop->slug) }}">{{ translate('Leave a review about ' . $shop->name) }}</a>
    </div>
</div>
