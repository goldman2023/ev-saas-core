@extends('frontend.layouts.company-profile-layout')

@section('company_profile')
 <x-company.company-tabs :seller="$seller" type="attachments"></x-company.company-tabs>

    <x-company.company-documents :company="$seller"></x-company.company-documents>

@endsection
