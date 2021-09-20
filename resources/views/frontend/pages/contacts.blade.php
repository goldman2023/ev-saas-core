@extends('frontend.layouts.app')

@section('content')
    <!-- Team Section -->
    <!-- Contact Form Section -->
    <x-default.contacts.sections.contact-form-with-map :map="true" :address="get_setting('contact_address')"></x-default.contacts.sections.contact-form-with-map>

<!-- End Contact Form Section -->

@endsection
