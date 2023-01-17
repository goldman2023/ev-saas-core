@extends('frontend.layouts.blank')

@section('meta_title'){{ translate('Request a quote').' | '.\TenantSettings::get('site_name').' |
'.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('request, quote, order, ecommerce') }}@stop

@section('meta')

@endsection

@push('head_scripts')

@endpush

@section('content')
<div class="flex justify-center after:content-[''] after:fixed after:w-1/2 after:right-0 after:bg-white after:z-[1] after:h-full after:shadow-xl
                before:content-[''] before:fixed before:w-1/2 before:left-0 before:bg-white before:z-0 before:h-full">

    <livewire:forms.request-quote-form />

</div>
@endsection

@section('modal')

@endsection

@push('footer_scripts')

@endpush
