@extends('frontend.layouts.user_panel')

@section('panel_content')
<div class="card">
    <div class="card-header">
        <h1>
            {{ translate('Manage menu') }}
        </h1>
    </div>
    <div class="card-body">
        @livewire('category-create')

    </div>
</div>



@endsection
