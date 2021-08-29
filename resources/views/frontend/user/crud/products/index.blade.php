@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card mb-3 mb-lg-5">
        <div class="card-header">
            <h5 class="card-title">{{ translate('All products') }}</h5>
            <a href="#" class="btn btn-primary btn-xs">{{ translate('Add new') }}</a>
        </div>
        <div class="card-body">
            {{-- TODO: Products Datatable --}}

        </div>
    <!--<div class="card-footer d-flex justify-content-end">
            <a class="btn btn-white" href="javascript:;">{{ translate('Cancel') }}</a>
            <span class="mx-2"></span>
            <a class="btn btn-primary" href="javascript:;">{{ translate('Save') }}</a>
        </div>-->
    </div>
@endsection
