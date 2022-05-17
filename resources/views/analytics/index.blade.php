@extends('frontend.layouts.user_panel')
@section('page_title', translate('App Settings'))

@section('panel_content')
  <section>
    <x-dashboard.section-headers.section-header title="{{ translate('Network Analytics') }}" text="">
        <x-slot name="content">
            <a href="/" target="_blank" class="btn-primary">
                @svg('heroicon-o-eye', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Preview website') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

   <div class="div">
    <iframe plausible-embed src="https://plausible.io/share/we-saas.com?auth=ahWbJrh7EOyxu3SZCyqq3&embed=true&theme=light&background=transparent" scrolling="no" frameborder="0" loading="lazy" style="width: 1px; min-width: 100%; height: 1600px;"></iframe>
    <div style="font-size: 14px; padding-bottom: 14px;">Stats powered by <a target="_blank" style="color: #4F46E5; text-decoration: underline;" href="https://plausible.io">Plausible Analytics</a></div>
    <script async src="https://plausible.io/js/embed.host.js"></script>
   </div>
  </section>


@endsection

