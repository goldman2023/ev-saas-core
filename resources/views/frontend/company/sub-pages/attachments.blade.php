@extends('frontend.layouts.company-profile-layout')

@section('company_profile')
 <x-company-tabs :seller="$seller" type="attachments"></x-company-tabs>

    <x-company-documents :company="$seller"></x-company-documents>

@endsection
