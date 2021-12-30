@extends('frontend.layouts.user_panel')
@section('page_title', translate('Manage Users'))
@section('meta_title', translate('Manage Users'))

@section('panel_content')
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="mb-0 h4">{{ translate('Account settings')}}</h4>
            <a class="btn btn-primary" href="#">
                @svg('heroicon-o-user', ['class' => 'mr-2 square-16']) {{ translate('My profile') }}
            </a>
        </div>
        <div class="card-body">
            asd
        </div>
    </div>

    <x-ev.toast id="my-account-updated-toast"
                position="bottom-center"
                class="bg-success border-success text-white h3"
                :is_x="true"
                :timeout="4000"
    ></x-ev.toast>
@endsection
