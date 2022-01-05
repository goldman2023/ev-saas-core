@extends('frontend.layouts.user_panel')

@section('panel_content')
<div class="card">
    <div class="card-header">
        <h4>{{ __('Website Analytics') }}</h4>
    </div>
    <div class="card-body">
        <iframe plausible-embed
            src="https://plausible.io/share/we-saas.com?auth=ahWbJrh7EOyxu3SZCyqq3&embed=true&theme=light"
            scrolling="no" frameborder="0" loading="lazy" style="width: 1px; min-width: 100%; height: 500px;"></iframe>
    </div>
</div>
<script async src="https://plausible.io/js/embed.host.js"></script>
@endsection
