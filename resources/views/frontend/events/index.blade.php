@extends('frontend.layouts.event-profile-layout')

@section('event_profile')
    <x-event-tabs :event="$detailedEvent" type="overview"></x-event-tabs>
    <div class="pl-lg-4">
        <h2 class="h3">{{ translate('Event Description') }}</h2>
        {{ $detailedEvent->description }}
    </div>
 
@endsection
