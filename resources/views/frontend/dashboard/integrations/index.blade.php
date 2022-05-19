@extends('frontend.layouts.user_panel')
@section('page_title', translate('Integrations & Data Management'))


@section('panel_content')

<!-- Card -->
<div class="">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title mb-6 font-medium text-xl">
            {{ translate('Available Data Integrations') }}
        </h5>
    </div>

    <div class="card-body">
        <div class="grid grid-cols-4 gap-10">
            <div class="card col-4">
                <a class="btn btn-primary" href="{{ route('integrations.facebook-business.export') }}">
                    {{ translate('Facebook Business Shop Export') }}
                </a>
                <small class='text-center'>
                    {{ translate('Export your Facebook Business Shop data to a CSV file.') }}

                    {{-- TODO: Add a documentation and tutorial link to how to add items to fb business manager from csv
                    file --}}
                    <a href="#">
                        {{ translate('Learn more') }}
                    </a>
                </small>
            </div>
            <div class='card col-4'>
                <a class="btn btn-primary" href="{{ route('integrations.facebook-business.export') }}">
                    {{ translate('Instagram Shop Export') }}
                </a>
            </div>

            <div class='card col-4'>
                <a class="btn btn-primary mb-3" href="{{ route('integrations.facebook-business.export') }}">
                    {{ translate('Google Merchant Center Export') }}
                </a>
                <small class='text-xs text-gray-500'>
                    {{ translate('Export your Google Merchant Center data to a Google Sheets file.') }}

                    {{-- TODO: Add a documentation and tutorial link to how to add items to fb business manager from csv
                    file --}}
                    <a href="#">
                        {{ translate('Learn more') }}
                    </a>
                </small>
            </div>

            <div class='card col-4'>
                <a class="btn btn-primary" href="{{ route('integrations.woocommerce.import', ['orders']) }}">
                    {{ translate('WooCommerce orders synchronization') }}
                </a>
            </div>

            <div class="card col-span-4">
                <div class="grid grid-cols-4">
                    <h5 class="col-span-2 card-header-title font-medium text-xl mb-0">
                        {{ translate('Request custom integration and support') }}
                    </h5>
                    <div class="text-right">
                        {{-- TODO: add global support link --}}
                        <a class="btn btn-primary float-right" href="#">
                            {{ translate('Contact our integrations team') }}
                        </a>
                    </div>

                </div>

            </div>
        </div>


        <div>
            <div class="row">
                <div class="col-12">

                </div>
            </div>
            <div class="row">

            </div>

        </div>

    </div>
    <!-- End Header -->


    <!-- End Table -->
</div>
<!-- End Card -->

</div>
@endsection
