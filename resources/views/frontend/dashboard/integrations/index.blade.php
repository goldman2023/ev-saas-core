@extends('frontend.layouts.user_panel')
@section('page_title', translate('Integrations & Data Management'))


@section('panel_content')

<!-- Card -->
<div class="card">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title">
            {{ translate('Available Integrations') }}
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <a class="btn btn-primary" href="{{ route('integrations.facebook-business.export') }}">
                    {{ translate('Facebook Business Shop Export') }}
                </a>
                <small class='text-center'>
                    {{ translate('Export your Facebook Business Shop data to a CSV file.') }}

                    {{-- TODO: Add a documentation and tutorial link to how to add items to fb business manager from csv file --}}
                    <a href="#">
                        {{ translate('Learn more') }}
                    </a>
                </small>
            </div>
            <div class='col-4'>
                <a class="btn btn-primary" href="{{ route('integrations.facebook-business.export') }}">
                    {{ translate('Instagram Shop Export') }}
                </a>
            </div>

            <div class='col-4'>
                <a class="btn btn-primary" href="{{ route('integrations.facebook-business.export') }}">
                    {{ translate('Google Merchant Center Export') }}
                </a>
                <small class='text-center'>
                    {{ translate('Export your Google Merchant Center data to a Google Sheets file.') }}

                    {{-- TODO: Add a documentation and tutorial link to how to add items to fb business manager from csv file --}}
                    <a href="#">
                        {{ translate('Learn more') }}
                    </a>
                </small>
            </div>
        </div>


    <div>
        <div class="row">
            <div class="col-12">

            </div>
        </div>
        <div class="row">
            <div class='col-4'>
                <a class="btn btn-primary" href="{{ route('integrations.woocommerce.import', ['orders']) }}">
                    {{ translate('WooCommerce orders synchronization') }}
                </a>
            </div>
        </div>

    </div>

    </div>
    <!-- End Header -->


    <!-- End Table -->
</div>
<!-- End Card -->

</div>
@endsection
