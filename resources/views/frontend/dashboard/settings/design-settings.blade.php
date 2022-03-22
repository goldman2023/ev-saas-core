@extends('frontend.layouts.user_panel')
@section('page_title', translate('Manage Design'))

@section('panel_content')
<!-- Basic Info-->
<div class="card mb-3">
    <div class="card-header p-4">
        <h5 class="h3 text-xl fw-600">{{ translate('Design Settings')}}</h5>
    </div>
    <div class="card-body">
        <div class="p-4">
            <x-default.system.theme-select-form />
        </div>
        <!-- End Tab Content -->

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">{{translate('Update Settings')}}</button>
        </div>
    </div>
</div>
@endsection
