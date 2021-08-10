@extends('backend.layouts.app-datatable')

@section('content')

    @include('backend.sellers.components.header-index',['is_datatable_view' => 'true'])

    {{$dataTable->table(['class' => 'table-responsive', 'style' => 'width: 100%'])}}
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush


