@extends('frontend.layouts.app')

@section('content')
    <x-page-hero-company></x-page-hero-company>
    <!-- Team Section -->
    <div class="container space-2" id="b2bwood-team" style="max-width: 1000px;">
        <!-- Title -->
        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
            <span class="d-block small font-weight-bold text-cap mb-2">{{ translate('Founders') }}</span>
            <h1>{{ translate('B2BWood Team') }}</h1>
            <p>
                {{ translate('Our Team goal is to Digitalize commodities trade in the forest industry to make it safer & transparently. 
Promote sustainable forestry and lean economy. ') }}
            </p>
        </div>
        <!-- End Title -->
        <div class="row">
            @php
                $team = [];
                
                $team[] = [
                    'name' => 'Giedrius Balbierius',
                    'text' => translate('Has been working in the Forestry industry for 12 years. 5 years in Fintech at Verifo. Founder and CEO of multiple ventures including forest harvesting, sawmills and floor manufacturing companies.'),
                    'linked_in' => 'https://www.linkedin.com/in/balbierius/',
                    'photo' => asset('assets/img/team/giedrius.jpeg'),
                    'title' => translate('CEO'),
                ];
                
                $team[] = [
                    'name' => 'Eimantas Kasperiunas',
                    'text' => translate('Technical Manager for agile and efficient software development teams. 10 years of experience working with web based solutions for enterprise. ROI and Data driven digital business solutions expert.'),
                    'linked_in' => 'https://www.linkedin.com/in/eimkasp/',
                    'photo' => asset('assets/img/team/eimantas.jpeg'),
                    'title' => translate('CTO'),
                ];
                
                $team[] = [
                    'name' => 'Alex Wysocki',
                    'text' => translate('General manager, EU operations at PNORS. 10+ years as serial entrepreneur in the forestry, e-commerce, management, IT & DT technologies, sales & marketing strategy.'),
                    'linked_in' => 'https://www.linkedin.com/in/aleksandrwysocki/',
                    'photo' => asset('assets/img/team/alex.jpeg'),
                    'title' => translate('Director of Product Management'),
                ];
            @endphp
            @for ($i = 0; $i < 3; $i++)
                @php
                    $item = $team[$i];
                @endphp
                <x-team-card :item="$item"></x-team-card>
            @endfor
        </div>

    </div>


    {{-- @php
    $button_text = 'Try it out';
    $image_source = 'assets/img/img1.jpg';
    $heading = 'Register to B2BWood';
    $body = "Building brands people can't live without is how our clients grow.";
    @endphp
    <x-promo-banner :heading="$heading" :body="$body" :buttonText="$button_text" :imageSource="$image_source">
    </x-promo-banner> --}}
    <!-- End Team Section -->
@endsection
