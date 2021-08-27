@php
    $conversation_count = \App\Models\Conversation::where('receiver_id', auth()->user()->id)->count();
@endphp

<div class="container">
    <div class="card card-body mb-3 mb-lg-5">
        <div class="row gx-lg-4">
            <div class="col-sm-6 col-lg-3">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Profile views') }}</h6>
                        <span
                            class="card-title h3">{{ (visits(auth()->user()->seller)->period('month')->count()+visits(auth()->user()->seller,"auth")->period('month')->count()) == 0 ? 0 : (visits(auth()->user()->seller)->period('month')->count()+visits(auth()->user()->seller,"auth")->period('month')->count())  }}</span>

                        <div class="d-flex align-items-center">
                            <span class="d-block font-size-sm">{{ translate('This month') }}</span>
                            <span class="badge badge-soft-success ml-2 w-auto">
                                <i class="tio-trending-up"></i> 4.3%
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                      <i class="las la-eye"></i>
                    </span>
                </div>

                <div class="d-lg-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-sm d-none">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Average Rating') }}</h6>
                        <span class="card-title h3">5/5</span>

                        <div class="d-flex align-items-center">
                            <span class="d-block font-size-sm text-nowrap">
                                {{ translate('Number of Reviews:') }}
                            </span>
                            <span class="badge badge-soft-success ml-2 w-auto">
                                <i class="las la-tree"></i> 42
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                        <i class="tio-website"></i>
                    </span>
                </div>

                <div class="d-lg-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-lg">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Website Clicks') }}</h6>
                        <span class="card-title h3">
                            {{ (visits(auth()->user()->shop,"website_click")->period('month')->count()) == 0 ? 0 : (visits(auth()->user()->shop,"website_click")->period('month')->count())  }}
                        </span>

                        <div class="d-flex align-items-center">
                            <span class="d-block font-size-sm">
                                {{ translate('This month') }}
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                      <i class="las la-ruler-combined"></i>
                    </span>
                </div>

                <div class="d-sm-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-sm">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Requests') }}</h6>
                        <span class="card-title h3">{{$conversation_count}}</span>

                        <div class="d-flex align-items-center">
                            <span class="d-block font-size-sm">
                                {{ translate('Number of new contacts') }}
                            </span>
                            <span class="badge badge-soft-danger ml-2 w-auto">
                                <i class="tio-trending-down"></i> 4.4%
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                      <i class="las la-poll"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
