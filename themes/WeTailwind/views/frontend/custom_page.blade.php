@extends('frontend.layouts.app')

@section('meta_title'){{ $page->getPageMeta()['title'] }} | {{ get_site_name() }}@stop

@section('meta_description'){{ $page->getPageMeta()['description'] }}@stop
@section('meta')
<meta property="og:title" content="{{ $page->getPageMeta()['title'] }}" />
<meta property="og:type" content="article" />
<meta property="og:article:author" content="article" />
<meta property="og:article:published_time" content="{{ $page->created_at }}" />
<meta property="og:article:modified_time" content="{{ $page->updated_at }}" />
<meta property="og:image" content="{{ $page->getPageMeta()['image'] }}" />
<meta property="og:description" content="{{ $page->getPageMeta()['description'] }}" />
<meta property="og:site_name" content="{{ get_site_name() }}" />

<meta property="twitter:image" content="{{ $page->getPageMeta()['image'] }}" />
<meta property="twitter:title" content="{{ $page->getPageMeta()['title'] }}" />
<meta property="twitter:description" content="{{ $page->getPageMeta()['description'] }}" />
<meta property="twitter:card" content="summary_large_image" />


<link rel="preload" href="https://cdn.tailwindcss.com" as="script" />
<script src="https://cdn.tailwindcss.com"></script>
@include('frontend.layouts.global-partials.global-tailwind-config')

@endsection

@section('content')
@if($page->slug != 'home')
@if(get_tenant_setting('breadcrumbs_feature', false))
{{ Breadcrumbs::render('home', $page) }}
@endif
@endif


@if($page->type === 'wysiwyg')
<div class="container py-10">
    {!! $page->content !!}
</div>
@elseif($page->type === 'html')
<div class="w-full relative">
    @auth
    @if (auth()->user()->isAdmin())
    @if( $page->id )

    <a target="_blank" href="{{ route('grape.index', [ $page->id]) }}" class="absolute top-0 right-0 btn-primary"
        style="z-index: 99999;">
        {{ translate('Edit Page') }}
    </a>
    @endif
    @endif
    @endauth

    {!! $page->content !!}
</div>
@elseif($page->type === 'system')
@if(!empty($page->template) && \File::exists(Theme::path($path =
'/views/frontend/page-templates').'/'.$page->template.'.blade.php'))
@include('frontend.page-templates.'.$page->template)
@endif
@else
@if(!empty($sections))
@foreach ($sections as $key => $section)
@if($section['id'] === 'html' && !empty($section['html'] ?? null))
{!! $section['html'] !!}
@else
<section class="relative">
    <x-dynamic-component :component="$section['id'] ?? ''" :we-data="$section['data'] ?? []"
        :settings="$section['settings'] ?? []" {{-- :uuid="$section['uuid'] ?? ''" --}} class="mt-4" />

    @auth
    @if (auth()->user()->isAdmin())
    @php
    if(isset($section['data']['hero_info_slot']['components']['hero_info_label']['data']['label'])) {
    $dynamic_section_id = $section['data']['hero_info_slot']['components']['hero_info_label']['data']['label'];
    }
    @endphp

    @if( $dynamic_section_id )
    <a target="_blank" href="{{ route('grape.section-editor', [ $dynamic_section_id]) }}"
        class="text-xs text-primary-700 absolute top-6 right-6 flex py-2 px-3 bg-primary-200 hover:text-white hover:bg-primary-600 rounded">
        {{ translate('Edit Section') }}
        @svg('heroicon-o-pencil', ['class' => 'h-4 h-4 ml-2'])
    </a>
    @endif
    @endif
    @endauth
</section>
@endif

@endforeach
@endif
@endif

@endsection
