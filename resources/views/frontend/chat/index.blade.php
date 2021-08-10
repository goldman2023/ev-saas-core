@extends('frontend.layouts.app')

@section('content')
<h1>Chat</h1>

  <div id="app">
  </div>



@endsection


@section('script')
    <script src="{{ asset('js/app.js') }}" ></script>
@endsection