<!-- Features Section -->
<div class="container space-2" style="max-width: 1000px;">
    <div class="row justify-content-lg-between align-items-lg-center">
        <div class="col-lg-6 mb-9 mb-lg-0">
            <div class="mb-3">
                <h1 class="h1 display-4">{{ translate('About B2BWood') }}</h1>
            </div>


            <p>
                {{ translate('B2BWood is Lithuanian Digital Technologies company focusing on data, digital products for timber companies and pulp companies. It was founded in June 2020 by professionals with entrepreneur experience in timber trade, e-commerce, IT & Digital Technologies.') }}
            </p>

            <div class="mt-4">
                <a class="btn btn-primary btn-wide transition-3d-hover" href="#b2bwood-team">
                {{ translate('B2BWood Team') }}
                </a>
                <span class="pl-2 pr-2">
                {{-- {{ translate('-- or --')}} --}}
                </span>
                <a class="btn btn-success btn-wide text-white transition-3d-hover" href="{{ route('custom-pages.show_custom_page', 'contacts') }}">
                {{ translate('Contact B2BWood') }}
                </a>
                {{-- <x-join-button></x-join-button> --}}
            </div>
        </div>

        <div class="col-lg-6 col-xl-5">
            <!-- SVG Element -->
            <div class="position-relative min-h-500rem mx-auto" style="max-width: 28rem;">
                <figure class="position-absolute top-0 right-0 z-index-2 mr-11">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 450 450" width="165"
                        height="165">
                        <g>
                            <defs>
                                <path id="circleImgID2" d="M225,448.7L225,448.7C101.4,448.7,1.3,348.5,1.3,225l0,0C1.2,101.4,101.4,1.3,225,1.3l0,0
                  c123.6,0,223.7,100.2,223.7,223.7l0,0C448.7,348.6,348.5,448.7,225,448.7z" />
                            </defs>
                            <clipPath id="circleImgID1">
                                <use xlink:href="#circleImgID2" />
                            </clipPath>
                            <g clip-path="url(#circleImgID1)">
                                <image width="450" height="450" xlink:href="{{ asset('assets/img/promo/b2b-wood-logo-bg.jpeg') }}"></image>
                            </g>
                        </g>
                    </svg>
                </figure>

                <figure class="position-absolute top-0 left-0">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 335.2 335.2" width="120"
                        height="120">
                        <circle fill="none" stroke="#377DFF" stroke-width="75" cx="167.6" cy="167.6" r="130.1" />
                    </svg>
                </figure>

                <figure class="d-none d-sm-block position-absolute top-0 left-0 mt-11">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 515 515" width="200"
                        height="200">
                        <g>
                            <defs>
                                <path id="circleImgID4" d="M260,515h-5C114.2,515,0,400.8,0,260v-5C0,114.2,114.2,0,255,0h5c140.8,0,255,114.2,255,255v5
                  C515,400.9,400.8,515,260,515z" />
                            </defs>
                            <clipPath id="circleImgID3">
                                <use xlink:href="#circleImgID4" />
                            </clipPath>
                            <g clip-path="url(#circleImgID3)">
                                <image width="515" height="515" xlink:href="{{ asset('assets/img/promo/b2bwood-trade.jpg') }}"
                                    transform="matrix(1 0 0 1 1.639390e-02 2.880859e-02)"></image>
                            </g>
                        </g>
                    </svg>
                </figure>

                <figure class="position-absolute top-0 right-0" style="margin-top: 11rem; margin-right: 13rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 67 67" width="25" height="25">
                        <circle fill="#00C9A7" cx="33.5" cy="33.5" r="33.5" />
                    </svg>
                </figure>

                <figure class="position-absolute top-0 right-0 mr-3" style="margin-top: 8rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 141 141" width="50"
                        height="50">
                        <circle fill="#FFC107" cx="70.5" cy="70.5" r="70.5" />
                    </svg>
                </figure>

                <figure class="position-absolute bottom-0 right-0">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 770.4 770.4" width="280"
                        height="280">
                        <g>
                            <defs>
                                <path id="circleImgID6" d="M385.2,770.4L385.2,770.4c212.7,0,385.2-172.5,385.2-385.2l0,0C770.4,172.5,597.9,0,385.2,0l0,0
                  C172.5,0,0,172.5,0,385.2l0,0C0,597.9,172.4,770.4,385.2,770.4z" />
                            </defs>
                            <clipPath id="circleImgID5">
                                <use xlink:href="#circleImgID6" />
                            </clipPath>
                            <g clip-path="url(#circleImgID5)">
                                <image width="900" height="900" xlink:href="{{ asset('assets/img/promo/b2bwood-kaunas-2.jpg') }}"
                                    transform="matrix(1 0 0 1 -64.8123 -64.8055)"></image>
                            </g>
                        </g>
                    </svg>
                </figure>
            </div>
            <!-- End SVG Element -->
        </div>
    </div>
</div>
<!-- End Features Section -->
