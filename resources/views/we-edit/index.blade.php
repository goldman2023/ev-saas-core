@extends('frontend.layouts.we-edit-layout')

@push('head_scripts')
<link
  rel="stylesheet"
  href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
/>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>
@endpush

@section('content')
    <livewire:we-edit />
@endsection
