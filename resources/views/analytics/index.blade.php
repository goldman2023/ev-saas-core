@extends('frontend.layouts.user_panel')

@section('panel_content')


<iframe src='https://www.youtube.com/live_chat?v=yDc9BonIXXI&embed_domain=your.domain.web' width="100%" height="600" frameborder='no' scrolling='no'></iframe>


<iframe plausible-embed src="https://plausible.io/we-saas.com?embed=true&theme=system" scrolling="no" frameborder="0"
    loading="lazy" style="width: 1px; min-width: 100%; height: 1600px;"></iframe>
<div style="font-size: 14px; padding-bottom: 14px;">Stats powered by <a target="_blank"
        style="color: #4F46E5; text-decoration: underline;" href="https://plausible.io">Plausible Analytics</a></div>
<script async src="https://plausible.io/js/embed.host.js"></script>

@endsection
