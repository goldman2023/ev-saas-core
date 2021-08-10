@extends('frontend.layouts.company-profile-layout')

@section('company_profile')
    <x-company-tabs :seller="$seller" type="gallery"></x-company-tabs>
    
    {{-- TODO: Create an empty state component like in frontend/company/sub-pages/reviews.blade.php --}}
    <x-company-gallery :company="$seller"></x-company-gallery>
@endsection
