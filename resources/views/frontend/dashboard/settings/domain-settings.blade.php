@extends('frontend.layouts.user_panel')
@section('page_title', translate('Manage Design'))

@section('panel_content')
    <!-- Basic Info-->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Domain Settings') }}</h5>
        </div>
        <div class="card-body">
            <livewire:domains/>
        </div>
    </div>
@endsection
