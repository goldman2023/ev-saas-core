{{-- This is child layout only for company profile pages, this should extend the main layout, app.blade.php --}}

@extends('frontend.layouts.app')


@section('content')
    <div class="b2b-company-profile">
        <div class="bg-img-hero b2b-company-profile__cover"
            style="background: URL('{{uploaded_asset($detailedEvent->upload_id)}}'); background-size: 100%;">
            <div class="container space-3 space-lg-3">
                <div class="w-lg-65 text-center mx-lg-auto">

                </div>
            </div>
        </div>
        <div class="container space-2 space-lg-0 ">
            <div class="row flex-lg-row flex-sm-column-reverse">
                <div id="stickyBlockStartPoint" class="b2b-company-details-card col-lg-3 mb-7 mb-lg-0"
                    style="margin-top: -150px;">
                    <!-- Sidebar Content -->
                    <div class="js-sticky-block card bg-white">
                        <div class="card-header text-center py-5 d-block">
                            <div class="d-block b2b-verified-icon mt-3 w-100">
                                <h1 class="" style="font-size: 18px;">
                                    {{ $detailedEvent->title }}
                                </h1>
                            </div>
                        </div>

                        <div class="text-center">
                            <div id="clockdiv">
                                <div>
                                    <span class="days">2</span>
                                    <p class="smalltext">Day</p>
                                </div>
                                <div>
                                    <span class="hours">22</span>
                                    <p class="smalltext">Hours</p>
                                </div>
                                <div>
                                    <span class="minutes">23</span>
                                    <p class="smalltext">Mins</p>
                                </div>
                                <div>
                                    <span class="seconds">56</span>
                                    <p class="smalltext">Secs</p>
                                </div>
                            </div>  
                        </div>

                        <div class="card-body">
                            <div class="border-bottom pb-2 mb-4">
                                @php
                                    $date = '';
                                @endphp
                                @foreach ($attributes as $attribute)
                                    @if(count($detailedEvent->attributes->where('attribute_id', $attribute->id))>0)
                                        @php
                                        if($attribute->type == "date") $date =$detailedEvent->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
                                        @endphp
                                        <dl class="row font-size-1">
                                            <dt class="col-sm-12 text-dark">{{ translate($attribute->name) }}</dt>

                                            <dd class="col-sm-12 text-body">
                                                @if ($attribute->type == "country")
                                                    @php 
                                                        $country = App\Models\Country::where('code', $detailedEvent->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values)->first();
                                                    @endphp
                                                    {{$country->name}}
                                                @else
                                                    {{$detailedEvent->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values}}
                                                @endif
                                            </dd>
                                        </dl>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 space-lg-1 mb-0">
                    @yield('event_profile')
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            var date = "{{$date}}";
            
            function getTimeRemaining(endtime) {
                const total = Date.parse(endtime) - Date.parse(new Date());
                if(total<0){
                    return null;
                }
                const seconds = Math.floor((total / 1000) % 60);
                const minutes = Math.floor((total / 1000 / 60) % 60);
                const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
                const days = Math.floor(total / (1000 * 60 * 60 * 24));
                
                return {
                    total,
                    days,
                    hours,
                    minutes,
                    seconds
                };
            }

            function initializeClock(id, endtime) {
                const clock = document.getElementById(id);
                const daysSpan = clock.querySelector('.days');
                const hoursSpan = clock.querySelector('.hours');
                const minutesSpan = clock.querySelector('.minutes');
                const secondsSpan = clock.querySelector('.seconds');

                function updateClock() {
                    const t = getTimeRemaining(endtime);
                    
                    if(t == null){
                        clock.style.display = 'none';
                    }else{
                        daysSpan.innerHTML = t.days;
                        hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                        if (t.total <= 0) {
                            clearInterval(timeinterval);
                        }
                    }
                   
                }

                updateClock();
                const timeinterval = setInterval(updateClock, 1000);    
            }
            if(date) {
                const deadline = new Date(date.slice(6, 10)+ "-" + date.slice(3, 5) + "-" +date.slice(0, 2));
                initializeClock('clockdiv', deadline);
            }else{
                document.getElementById('clockdiv').style.display = 'none';
            }
            
        </script>
      
    @endsection