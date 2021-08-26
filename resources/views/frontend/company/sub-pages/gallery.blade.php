@extends('frontend.layouts.company-profile-layout')

@section('company_profile')
    <x-company.company-tabs :seller="$seller" type="gallery"></x-company.company-tabs>

    {{-- TODO: Create an empty state component like in frontend/company/sub-pages/reviews.blade.php --}}
    <x-company.company-gallery :company="$seller"></x-company.company-gallery>
@endsection
