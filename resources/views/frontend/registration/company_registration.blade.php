@extends('frontend.layouts.app')

@section('content')

    <div class="container-fluid px-3">
        <div class="row">
            <!-- Cover -->
            <div
                class="col-lg-6 d-flex justify-content-center align-items-start pt-10 min-vh-lg-100 position-relative bg-light px-0">
                
                <div style="max-width: 33rem;" class="pl-3">
                   

                    <div class="mb-5">
                        <h2 class="display-4 text-center text-lg-left">
                            {{ translate('Become a B2BWood Club Member') }}
                        </h2>
                    </div>

                    <!-- List Checked -->
                    <ul class="list-checked list-checked-lg list-checked-primary list-unstyled-py-4">
                        <li class="list-checked-item">
                            <span class="d-block font-weight-bold mb-1">
                                {{ translate('Present your business online') }}
                            </span>

                            {{ translate('Get your free company profile and stay on top of global wood
                            industry trends with B2BWood Club Membership') }}

                        </li>

                        <li class="list-checked-item">
                            <span class="d-block font-weight-bold mb-1">{{ translate('Find verified partners') }}</span>
                            {{ translate('Discover new members, potential partners and verified companies') }}
                        </li>

                         <li class="list-checked-item">
                            <span class="d-block font-weight-bold mb-1">
                                {{ translate('Get Verified') }}
                            </span>

                            {{ translate('Evaluate and show your company performance and reputation with analyst data from B2BWood') }}

                        </li>
                    </ul>

                     <div class="text-center mb-5">
                        <img class="img-fluid"
                            src="{{ asset('assets/img/promo/b2b-company-profile.png') }}"
                            alt="B2BWood Company Profile" style="width:100%">
                    </div>
                    <!-- End List Checked -->

                    <div class="row justify-content-between mt-5 gx-2">

                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Cover -->

            <div class="col-lg-6 d-flex justify-content-center align-items-center min-vh-lg-100">
                <div class="w-100 pt-10 pt-lg-7 pb-7">
                    <!-- Form -->
                    <x-company-registration-form> </x-company-registration-form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection
