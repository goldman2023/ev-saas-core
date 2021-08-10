@extends('frontend.layouts.company-profile-layout')

@section('company_profile')


    <x-company-tabs :seller="$seller" type="news"></x-company-tabs>

    <div class="row">
        <div class="col-12 mb-3">
            <h1>{{ translate('Press releases of ') }} {{ $seller->user->shop->name }}
                <hr>
        </div>
    </div>
        <div class="company-pr-item ">
            <div class="row mx-md-n2 mb-3">
                <div class="col-md-4 px-md-2 mb-3 mb-md-0">
                    <div class="position-relative">
                        <img class="img-fluid w-100 rounded-lg"
                            src="{{ asset('assets/img/press-releases/b2b-wood-logo-pr.png') }}" alt="Company Joined B2BWood Club">

                        <div class="position-absolute top-0 left-0 mt-3 ml-3">
                            <small
                                class="btn btn-xs btn-success btn-pill text-white text-uppercase shadow-soft py-1 px-2 mb-3">{{ translate('New Member!') }}</small>
                        </div>

                        
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="media mb-2">
                        <div class="media-body mr-7">
                            <h3 class="text-hover-primary">
                                <a href="#">
                                    {{ $seller->user->shop->name }} {{ translate('Joined B2BWood Club') }}
                                </a>
                            </h3>
                        </div>

                        <div class="d-flex mt-1 ml-auto">
                            <div class="text-right">

                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start align-items-center small text-muted mb-2">

                        <div class="">
                            
                        </div>
                        {{-- <span class="text-muted mx-2">|</span> --}}
                        <div class="d-inline-block">
                            <i class="la la-clock mr-1"></i>
                            {{ $seller->created_at->diffForHumans() }}
                        </div>

                    </div>

                    <p class="font-size-1 text-body mb-0">
                    {{ translate('We are happy to announce, that ') }} {{ $seller->user->shop->name }} {{ translate(" joined B2BWood Club and became a member of global truested timber industry companies community") }}
                    </p>

                </div>
            </div>
        </div>
        {{-- TODO: For company owner add a link to submit the PR content --}}
    <!-- End Card -->
@endsection
