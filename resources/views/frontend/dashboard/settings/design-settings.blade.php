@extends('frontend.layouts.user_panel')
@section('page_title', translate('Manage Design'))

@section('panel_content')
    <!-- Basic Info-->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Design Settings')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-ev.form.select name="product_card_design_archive" :items="BusinessSettings::getMappedProductCardDesigns()" label="{{ translate('Video provider') }}"  placeholder="{{ translate('Select the provider...') }}" />

                <x-ev.form.file-selector name="product.pdf" label="{{ translate('Website Logo') }}" datatype="document" placeholder="{{ translate('Choose file...') }}"></x-ev.form.file-selector>


                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Update Settings')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

