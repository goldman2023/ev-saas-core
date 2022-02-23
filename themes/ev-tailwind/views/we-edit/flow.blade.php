@extends('frontend.layouts.whitelabel')

@section('content')
<div class="App">
<div id="root"></div>

<style>
    html,
    body,
    #root,
    .App {
        height: 100%;
        width: 100%;
    }

    .App {
        font-family: sans-serif;
        text-align: center;
    }
</style>
<h1> We Flow </h1>
</div>
<script src="{{ static_asset('we-edit/index.js', false, true, true) }}"></script>

@endsection
