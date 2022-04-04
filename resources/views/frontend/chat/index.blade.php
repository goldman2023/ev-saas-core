@extends('frontend.layouts.user_panel')

@section('panel_content')
<div class="container">
    <div class="grid grid-cols-4 gap-10">
        <div class="col-span-3">
            <x-default.chat.main-chat></x-default.chat.main-chat>
        </div>
        <div class="col-span-1">
            <x-dashboard.elements.support-card class="mb-3">
            </x-dashboard.elements.support-card>
        </div>
    </div>
</div>
@endsection


