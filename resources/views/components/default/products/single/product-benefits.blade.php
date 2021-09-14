<div id="shopCartAccordionExample2" class="accordion mt-5">
    <!-- Card -->
    <div class="card card-bordered shadow-none">
        <div class="card-body card-collapse" id="shopCardHeadingOne">
            <a class="btn btn-link btn-block card-btn collapsed" href="javascript:;" role="button"
                data-toggle="collapse" data-target="#shopCardOne" aria-expanded="false"
                aria-controls="shopCardOne">
                <span class="row align-items-center">
                    <span class="col-9">
                        <span class="media align-items-center">
                            <span class="w-100 max-w-6rem mr-3">
                                <img class="img-fluid"
                                    src="https://htmlstream.com/front/assets/svg/icons/icon-65.svg"
                                    alt="SVG">
                            </span>
                            <span class="media-body">
                                <span class="d-block font-size-1 font-weight-bold">
                                    <x-ev.label :label="ev_dynamic_translate('Benefit 1', true)">
                                    </x-ev.label>
                                </span>
                            </span>
                        </span>
                    </span>
                    <span class="col-3 text-right">
                        <span class="card-btn-toggle">
                            <span class="card-btn-toggle-default">+</span>
                            <span class="card-btn-toggle-active">−</span>
                        </span>
                    </span>
                </span>
            </a>
        </div>
        <div id="shopCardOne" class="collapse show" aria-labelledby="shopCardHeadingOne"
            data-parent="#shopCartAccordionExample2">
            <div class="card-body">
                <p>
                    <x-ev.label class="small" :label="ev_dynamic_translate('Benefit 1 Content', true)">
                    </x-ev.label>
                </p>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="card card-bordered shadow-none">
        <div class="card-body card-collapse" id="shopCardHeadingTwo">
            <a class="btn btn-link btn-block card-btn collapsed" href="javascript:;" role="button"
                data-toggle="collapse" data-target="#shopCardTwo" aria-expanded="false"
                aria-controls="shopCardTwo">
                <span class="row align-items-center">
                    <span class="col-9">
                        <span class="media align-items-center">
                            <span class="w-100 max-w-6rem mr-3">
                                <img class="img-fluid"
                                    src="https://htmlstream.com/front/assets/svg/icons/icon-64.svg"
                                    alt="SVG">
                            </span>
                            <span class="media-body">
                                <span class="d-block font-size-1 font-weight-bold">
                                    <x-ev.label :label="ev_dynamic_translate('Benefit 2', true)">
                                    </x-ev.label>

                                </span>
                            </span>
                        </span>
                    </span>
                    <span class="col-3 text-right">
                        <span class="card-btn-toggle">
                            <span class="card-btn-toggle-default">+</span>
                            <span class="card-btn-toggle-active">−</span>
                        </span>
                    </span>
                </span>
            </a>
        </div>
        <div id="shopCardTwo" class="collapse" aria-labelledby="shopCardHeadingTwo"
            data-parent="#shopCartAccordionExample2">
            <div class="card-body">
                <p class="small mb-0">
                    <x-ev.label class="small" :label="ev_dynamic_translate('Benefit 2 Content', true)">
                    </x-ev.label>

                </p>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
