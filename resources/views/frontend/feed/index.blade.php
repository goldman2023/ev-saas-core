@extends('frontend.layouts.feed')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-8">
                <h1>Feed</h1>
                <MySimpleComponent></MySimpleComponent>
                {{ $feedToken }}
                {{-- <FeedComponent token="{{ $feedToken }}"> </FeedComponent> --}}

                <div id="FeedComponent"> </div>
            </div>

            <div class="col-md-2">

            </div>
        </div>
    </div>
@endsection
