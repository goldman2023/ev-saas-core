@extends('frontend.layouts.app')

@section('content')
    <x-page-hero-company></x-page-hero-company>
    <!-- Team Section -->
    <div class="container space-2" id="ev-team" style="max-width: 1000px;">
        <!-- Title -->
        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
            <span class="d-block small font-weight-bold text-cap mb-2">{{ translate('Founders') }}</span>
            <h1>{{ translate('Team') }}</h1>
            <p>
                {{ translate('Team Page Description') }}
            </p>
        </div>
        <!-- End Title -->
        <div class="row">
            @php
            /* TODO: Make this dynamic somehow */
                $team = [];

                $team[] = [
                    'name' => 'John Doe',
                    'text' => translate('Lorem Ipsum'),
                    'linked_in' => 'https://www.linkedin.com/',
                    'photo' => asset('assets/img/team/giedrius.jpeg'),
                    'title' => translate('CEO'),
                ];
            @endphp
            @foreach ($team as $item)
                @php

                @endphp
                <x-team-card :item="$item"></x-team-card>
            @endforeach
        </div>

    </div>

@endsection
